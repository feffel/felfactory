<?php
declare(strict_types=1);

namespace felfactory\tests\TestModels;

use felfactory\Annotation as FCT;

class SimpleAnnotatedModel
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
     * @FCT\ObjectOf(SimpleAddressModel::class)
     */
    public $address;

    /**
     * @FCT\ManyOf(@FCT\Generate("phoneNumber"))
     */
    public $phoneNos;
}
