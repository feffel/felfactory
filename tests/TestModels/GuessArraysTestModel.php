<?php
declare(strict_types=1);

namespace felfactory\tests\TestModels;

class GuessArraysTestModel
{
    /**
     * @var string[]
     */
    public $names;

    /**
     * @var string[]
     */
    protected $phoneNumbers;

    /**
     * @var string[]
     */
    private $whatMate;

    /**
     * @var array
     */
    private $cool;

    /**
     * @var SimpleTestModel[]
     */
    public $objects;

    /**
     * @return string[]
     */
    public function getNames(): array
    {
        return $this->names;
    }

    /**
     * @return string[]
     */
    public function getPhoneNumbers(): array
    {
        return $this->phoneNumbers;
    }

    /**
     * @return string[]
     */
    public function getWhatMate(): array
    {
        return $this->whatMate;
    }

    /**
     * @return array
     */
    public function getCool(): array
    {
        return $this->cool;
    }

    /**
     * @return SimpleTestModel[]
     */
    public function getObjects(): array
    {
        return $this->objects;
    }
}
