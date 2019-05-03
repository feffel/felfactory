<?php
declare(strict_types=1);

namespace felfactory;

use Doctrine\Common\Annotations\PhpParser;
use function in_array;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;
use ReflectionProperty;
use Reflector;

/**
 * PhpDoc reader
 *
 * Class taken and adapted from php-di/phpdocreader.
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class PhpDocReader
{
    /**
     * @var PhpParser
     */
    private $parser;

    private const IGNORED_TYPES = [
        'bool',
        'boolean',
        'string',
        'int',
        'integer',
        'float',
        'double',
        'array',
        'object',
        'callable',
        'resource',
        'mixed',
    ];

    private const  SELF_KEYWORDS = [
        'self',
        'static',
    ];

    public function __construct()
    {
        $this->parser = new PhpParser();
    }

    /**
     * Parse the docblock of the property to get the class of the var annotation.
     *
     * @param ReflectionProperty $property
     *
     * @throws InvalidArgumentException
     * @return string|null Type of the property (content of var annotation)
     */
    public function getPropertyClass(ReflectionProperty $property): ?string
    {
        // Get the content of the @var annotation
        /** @noinspection NotOptimalRegularExpressionsInspection */
        if (preg_match('/@var\s+([^\s]+)/', $property->getDocComment() ?: '', $matches)) {
            [, $type] = $matches;
        } else {
            return null;
        }

        // Ignore primitive types
        if (in_array($type, self::IGNORED_TYPES, true)) {
            return null;
        }

        // Ignore types containing special characters ([], <> ...)
        if (! preg_match('/^[a-zA-Z0-9\\\\_]+$/', $type)) {
            return null;
        }

        $class = $property->getDeclaringClass();

        // If the class name is not fully qualified (i.e. doesn't start with a \)
        if ($type[0] !== '\\') {
            // Try to resolve the FQN using the class context
            $resolvedType = $this->tryResolveFqn($type, $class, $property);

            if (!$resolvedType) {
                throw new InvalidArgumentException(sprintf(
                    'The @var annotation on %s::%s contains a non existent class "%s". '
                    . 'Did you maybe forget to add a "use" statement for this annotation?',
                    $class->name,
                    $property->getName(),
                    $type
                ));
            }

            $type = $resolvedType;
        }

        if (!$this->classExists($type)) {
            throw new InvalidArgumentException(sprintf(
                'The @var annotation on %s::%s contains a non existent class "%s"',
                $class->name,
                $property->getName(),
                $type
            ));
        }

        // Remove the leading \ (FQN shouldn't contain it)
        $type = ltrim($type, '\\');

        return $type;
    }

    /**
     * Parse the docblock of the property to get the class of the param annotation.
     *
     * @param ReflectionParameter $parameter
     *
     * @throws InvalidArgumentException()
     * @return string|null Type of the property (content of var annotation)
     */
    public function getParameterClass(ReflectionParameter $parameter): ?string
    {
        // Use reflection
        $parameterClass = $parameter->getClass();
        if ($parameterClass !== null) {
            return $parameterClass->name;
        }

        $parameterName = $parameter->name;
        // Get the content of the @param annotation
        $method = $parameter->getDeclaringFunction();
        if (preg_match('/@param\s+([^\s]+)\s+\$' . $parameterName . '/', $method->getDocComment(), $matches)) {
            [, $type] = $matches;
        } else {
            return null;
        }

        // Ignore primitive types
        if (in_array($type, self::IGNORED_TYPES, true)) {
            return null;
        }

        // Ignore types containing special characters ([], <> ...)
        if (! preg_match('/^[a-zA-Z0-9\\\\_]+$/', $type)) {
            return null;
        }

        $class = $parameter->getDeclaringClass();

        // If the class name is not fully qualified (i.e. doesn't start with a \)
        if ($type[0] !== '\\') {
            // Try to resolve the FQN using the class context
            $resolvedType = $this->tryResolveFqn($type, $class, $parameter);

            if (!$resolvedType) {
                throw new InvalidArgumentException(sprintf(
                    'The @param annotation for parameter "%s" of %s::%s contains a non existent class "%s". '
                    . 'Did you maybe forget to add a "use" statement for this annotation?',
                    $parameterName,
                    $class->name,
                    $method->name,
                    $type
                ));
            }

            $type = $resolvedType;
        }

        if (!$this->classExists($type)) {
            throw new InvalidArgumentException(sprintf(
                'The @param annotation for parameter "%s" of %s::%s contains a non existent class "%s"',
                $parameterName,
                $class->name,
                $method->name,
                $type
            ));
        }

        // Remove the leading \ (FQN shouldn't contain it)
        $type = ltrim($type, '\\');

        return $type;
    }

    /**
     * Attempts to resolve the FQN of the provided $type based on the $class and $member context.
     *
     * @param string $type
     * @param ReflectionClass $class
     * @param Reflector $member
     *
     * @return string|null Fully qualified name of the type, or null if it could not be resolved
     */
    private function tryResolveFqn($type, ReflectionClass $class, Reflector $member): ?string
    {
        if (in_array($type, self::SELF_KEYWORDS, true)) {
            return $class->name;
        }
        $alias = ($pos = strpos($type, '\\')) === false ? $type : substr($type, 0, $pos);
        $loweredAlias = strtolower($alias);

        // Retrieve "use" statements
        $uses = $this->parser->parseClass($class);
        if (isset($uses[$loweredAlias])) {
            // Imported classes
            if ($pos !== false) {
                return $uses[$loweredAlias] . substr($type, $pos);
            }

            return $uses[$loweredAlias];
        }
        if ($this->classExists($class->getNamespaceName() . '\\' . $type)) {
            return $class->getNamespaceName() . '\\' . $type;
        }
        if (isset($uses['__NAMESPACE__']) && $this->classExists($uses['__NAMESPACE__'] . '\\' . $type)) {
            // Class namespace
            return $uses['__NAMESPACE__'] . '\\' . $type;
        }
        if ($this->classExists($type)) {
            // No namespace
            return $type;
        }
        if (PHP_VERSION_ID < 50400) {
            return null;
        }

        // If all fail, try resolving through related traits
        return $this->tryResolveFqnInTraits($type, $class, $member);
    }

    /**
     * Attempts to resolve the FQN of the provided $type based on the $class and $member context, specifically searching
     * through the traits that are used by the provided $class.
     *
     * @param string $type
     * @param ReflectionClass $class
     * @param Reflector $member
     *
     * @return string|null Fully qualified name of the type, or null if it could not be resolved
     */
    private function tryResolveFqnInTraits($type, ReflectionClass $class, Reflector $member): ?string
    {
        /** @var ReflectionClass[] $traits */
        $traits = [];

        // Get traits for the class and its parents
        while ($class) {
            $traits = array_merge($traits, $class->getTraits());
            $class = $class->getParentClass();
        }

        foreach ($traits as $trait) {
            // Eliminate traits that don't have the property/method/parameter
            if ($member instanceof ReflectionProperty && !$trait->hasProperty($member->name)) {
                continue;
            }
            if ($member instanceof ReflectionMethod && !$trait->hasMethod($member->name)) {
                continue;
            }
            if ($member instanceof ReflectionParameter && !$trait->hasMethod($member->getDeclaringFunction()->name)) {
                continue;
            }
            // Run the resolver again with the ReflectionClass instance for the trait
            $resolvedType = $this->tryResolveFqn($type, $trait, $member);

            if ($resolvedType) {
                return $resolvedType;
            }
        }
        return null;
    }

    /**
     * @param string $class
     * @return bool
     */
    private function classExists($class): bool
    {
        return class_exists($class) || interface_exists($class);
    }
}
