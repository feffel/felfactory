# felfactory

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-coverage]][link-coverage]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]


felfactory is a library that generates objects full of fake data for you. Whether you need to randomize test data, bootstrap your database, fill-in your persistence to stress test it, or anonymize data taken from a production service.

Powered by [Faker's](https://github.com/fzaninotto/Faker) data generators.

# Table of Contents

- [Installation](#installation)
- [Basic Usage](#basic-usage)
- [Configuration](#configuration)
- [Model Definitions](#model-definitions)
- [How it works](#how-it-works)
- [Contributing](#contributing)
- [License](#license)

## Installation

via composer

``` bash
composer require feffel/felfactory
```

## Basic Usage

Pass a class name to your factory instance, it will create and fill properties with the appropriate type of data.


``` php
class Person
{
    private $firstName;

    private $lastName;

    private $address;
}

$factory = new \felfactory\Factory();
$person  = $factory->generate(Person::class);
var_dump($person); 

//  class Person#2407 (3) {
//    private $firstName => string(6) "Breana"
//    private $lastName  => string(7) "Okuneva"
//    private $address   => string(43) "37382 Chanel Point Steuberchester, AR 83395"
//  }
```


## Configuration

Configuration uses enviornment variables, add these to your environment or add a `.env` file to your root project dir.

| Variable  |  Default | Description |
| :-------- | :------: | :---------- |
| FACTORY_MAX_NEST_LEVEL | 3 | The maximum allowed level of object nesting, any objects found after this level will be ignored and set to null |
| FACTORY_CIRCLE_TOLERANCE | 1 | Circular references tolerance, default 1 does not allow the generation of any circular or self refrencing objects |
| FACTORY_PHP_FILE  | null  | Php file path for model definitions |
| FACTORY_YAML_FILE  | null  | Yaml file path for model definitions |


## Model Definitions

You can provide model definitions to customize the generation of a model, the definition does not have to contain all of the properties, the factory will still guess the missing properties.

- __Generate__ accepts a faker generator property [eg: firstName, lastName, phoneNumber, ...]
- __Value__ accepts any php value and passes it down to property [eg: "string value", 15, null, ...]
- __ObjectOf__ accepts a FQCN and generates an object of this type [eg: namespace\models\Person , Person::class, ...]
- __ManyOf__ accepts any of the previous definitions as it's first parameter and generates an array of it bound by the inclusive range provided by it's second and third parameter.


#### Annotation definition

```php
use felfactory\Annotation as FCT;

class AnnotatedModel
{
    /**
     * @FCT\Generate("firstName")
     */
    public $firstName;

    /**
     * @FCT\Value("""felfel""")
     */
    protected $lastName;

    /**
     * @FCT\ObjectOf(AddressModel::class)
     */
    public $address;

    /**
     * @FCT\ManyOf(@FCT\Generate("phoneNumber"), 1, 3)
     */
    public $phoneNos;
}
```


#### Php defintion

```php
return [
    AnnotatedModel::class => [
        'firstName' => "generate('firstName')",
        'lastName'  => "value('\"felfel\"')",
        'address'   => "class(felfactory\models\AddressModel)",
        'phoneNos'  => "many(generate('phoneNumber'), 1, 3)"
    ],
];
```


## How it works

  The factory does not use the class's original constructor, nor the provided setters if any. All of the initiation process is handled by reflections. 
  
  The factory looks for the `@var` annotation on a property to determine it's type, if a definition is found for the property it will be used, otherwise it will be guessed based on type and name of the property.
  
  
  #### Objects
  If a property is found to be an object it will trigger another factory call to generate it, and the name will be ignored.
  Interfaces and abstract types will not be generated automatically and will be set to null.
    
  #### Scalar types and Non-annotated properties
  Scalar types will be guessed based on the name of the property first, if it doesn't match any of the supported data generators, it's generated based on type.


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Credits

- [felfel][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/feffel/felfactory.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/com/feffel/felfactory/master.svg?style=flat-square
[ico-coverage]: https://img.shields.io/codeclimate/coverage/feffel/felfactory.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/codeclimate/maintainability/feffel/felfactory.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/feffel/felfactory.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/feffel/felfactory
[link-travis]: https://travis-ci.com/feffel/felfactory
[link-coverage]: https://codeclimate.com/github/feffel/felfactory/test_coverage
[link-code-quality]: https://codeclimate.com/github/feffel/felfactory/maintainability
[link-downloads]: https://packagist.org/packages/feffel/felfactory
[link-author]: https://github.com/feffel
[link-contributors]: ../../contributors
