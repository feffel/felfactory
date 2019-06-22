<?php
return [
    'boolean' => ['factory' => 'makeGenerate', 'args' => ['boolean']],
    'bool'    => ['factory' => 'makeGenerate', 'args' => ['boolean']],
    'integer' => ['factory' => 'makeGenerate', 'args' => ['randomNumber']],
    'int'     => ['factory' => 'makeGenerate', 'args' => ['randomNumber']],
    'number'  => ['factory' => 'makeGenerate', 'args' => ['randomNumber']],
    'float'   => ['factory' => 'makeGenerate', 'args' => ['randomFloat']],
    'double'  => ['factory' => 'makeGenerate', 'args' => ['randomFloat']],
    'string'  => ['factory' => 'makeGenerate', 'args' => ['sentence']],
    'str'     => ['factory' => 'makeGenerate', 'args' => ['sentence']],
    'color'   => ['factory' => 'makeGenerate', 'args' => ['colorName']],
    'array'   => ['factory' => 'makeGenerate', 'args' => ['words']],
    'default' => ['factory' => 'makeGenerate', 'args' => ['word']],
];
