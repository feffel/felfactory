<?php
return [
    'name'      => [
        'first'     => ['factory' => 'makeGenerate', 'args' => ['firstName']],
        'last'      => ['factory' => 'makeGenerate', 'args' => ['lastName']],
        'street'    => ['factory' => 'makeGenerate', 'args' => ['streetName']],
        'user'      => ['factory' => 'makeGenerate', 'args' => ['userName']],
        'domain'    => ['factory' => 'makeGenerate', 'args' => ['domainName']],
        'month'     => ['factory' => 'makeGenerate', 'args' => ['monthName']],
        'safeColor' => ['factory' => 'makeGenerate', 'args' => ['safeColorName']],
        'color'     => ['factory' => 'makeGenerate', 'args' => ['colorName']],
        'city'      => ['factory' => 'makeGenerate', 'args' => ['city']],
        'default'   => ['factory' => 'makeGenerate', 'args' => ['name']],
    ],
    'title'     => [
        'female'  => ['factory' => 'makeGenerate', 'args' => ['titleFemale']],
        'male'    => ['factory' => 'makeGenerate', 'args' => ['titleMale']],
        'job'     => ['factory' => 'makeGenerate', 'args' => ['jobTitle']],
        'default' => ['factory' => 'makeGenerate', 'args' => ['title']],
    ],
    'city'      => [
        'suffix'  => ['factory' => 'makeGenerate', 'args' => ['citySuffix']],
        'name'    => ['factory' => 'makeGenerate', 'args' => ['city']],
        'default' => ['factory' => 'makeGenerate', 'args' => ['city']],
    ],
    'building'  => [
        'number'  => ['factory' => 'makeGenerate', 'args' => ['buildingNumber']],
        'default' => ['factory' => 'makeGenerate', 'args' => ['address']],
    ],
    'street'    => [
        'suffix'  => ['factory' => 'makeGenerate', 'args' => ['streetSuffix']],
        'address' => ['factory' => 'makeGenerate', 'args' => ['streetAddress']],
        'default' => ['factory' => 'makeGenerate', 'args' => ['streetName']],
    ],
    'address'   => [
        'street'  => ['factory' => 'makeGenerate', 'args' => ['streetAddress']],
        'mac'     => ['factory' => 'makeGenerate', 'args' => ['macAddress']],
        'default' => ['factory' => 'makeGenerate', 'args' => ['address']],
    ],
    'country'   => [
        'code'    => ['factory' => 'makeGenerate', 'args' => ['countryCode']],
        'iso'     => ['factory' => 'makeGenerate', 'args' => ['countryISOAlpha3']],
        'alpha'   => ['factory' => 'makeGenerate', 'args' => ['countryISOAlpha3']],
        'default' => ['factory' => 'makeGenerate', 'args' => ['country']],
    ],
    'latitude'  => [
        'default' => ['factory' => 'makeGenerate', 'args' => ['latitude']],
    ],
    'longitude' => [
        'default' => ['factory' => 'makeGenerate', 'args' => ['longitude']],
    ],
    'bool'      => [
        'default' => ['factory' => 'makeGenerate', 'args' => ['boolean']],
    ],
    'number'    => [
        'building' => ['factory' => 'makeGenerate', 'args' => ['buildingNumber']],
        'phone'    => ['factory' => 'makeGenerate', 'args' => ['phoneNumber']],
        'credit'   => ['factory' => 'makeGenerate', 'args' => ['creditCardNumber']],
        'card'     => ['factory' => 'makeGenerate', 'args' => ['creditCardNumber']],
        'bank'     => ['factory' => 'makeGenerate', 'args' => ['bankAccountNumber']],
        'account'  => ['factory' => 'makeGenerate', 'args' => ['bankAccountNumber']],
        'swift'    => ['factory' => 'makeGenerate', 'args' => ['swiftBicNumber']],
        'default'  => ['factory' => 'makeGenerate', 'args' => ['phoneNumber']],
    ],
    'credit'    => [
        'type'    => ['factory' => 'makeGenerate', 'args' => ['creditCardType']],
        'number'  => ['factory' => 'makeGenerate', 'args' => ['creditCardNumber']],
        'exp'     => ['factory' => 'makeGenerate', 'args' => ['creditCardExpirationDateString']],
        'date'    => ['factory' => 'makeGenerate', 'args' => ['creditCardExpirationDateString']],
        'details' => ['factory' => 'makeGenerate', 'args' => ['creditCardDetails']],
        'default' => ['factory' => 'makeGenerate', 'args' => ['creditCardNumber']],
    ],
    'color'     => [
        'hex'     => ['factory' => 'makeGenerate', 'args' => ['hexColor']],
        'rgb'     => ['factory' => 'makeGenerate', 'args' => ['rgbColor']],
        'css'     => ['factory' => 'makeGenerate', 'args' => ['rgbCssColor']],
        'name'    => ['factory' => 'makeGenerate', 'args' => ['colorName']],
        'default' => ['factory' => 'makeGenerate', 'args' => ['colorName']],
    ],
    'word'      => [
        'default' => ['factory' => 'makeGenerate', 'args' => ['word']],
    ],
    'sentence'  => [
        'default' => ['factory' => 'makeGenerate', 'args' => ['sentence']],
    ],
    'paragraph' => [
        'default' => ['factory' => 'makeGenerate', 'args' => ['paragraph']],
    ],
    'text'      => [
        'default' => ['factory' => 'makeGenerate', 'args' => ['text']],
    ],
    'email'     => [
        'default' => ['factory' => 'makeGenerate', 'args' => ['email']],
    ],
    'username'  => [
        'default' => ['factory' => 'makeGenerate', 'args' => ['username']],
    ],
    'password'  => [
        'default' => ['factory' => 'makeGenerate', 'args' => ['password']],
    ],
    'domain'    => [
        'name'    => ['factory' => 'makeGenerate', 'args' => ['domainName']],
        'word'    => ['factory' => 'makeGenerate', 'args' => ['domainWord']],
        'default' => ['factory' => 'makeGenerate', 'args' => ['domainName']],
    ],
    'url'       => [
        'default' => ['factory' => 'makeGenerate', 'args' => ['url']],
    ],
    'slug'      => [
        'default' => ['factory' => 'makeGenerate', 'args' => ['slug']],
    ],
    'locale'      => [
        'default' => ['factory' => 'makeGenerate', 'args' => ['locale']],
    ],
    'time'      => [
        'iso'     => ['factory' => 'makeGenerate', 'args' => ['iso8601']],
        'unix'    => ['factory' => 'makeGenerate', 'args' => ['unixTime']],
        'stamp'   => ['factory' => 'makeGenerate', 'args' => ['unixTime']],
        'zone'    => ['factory' => 'makeGenerate', 'args' => ['timezone']],
        'default' => ['factory' => 'makeGenerate', 'args' => ['datetime']],
    ],
    'day'       => [
        'month'   => ['factory' => 'makeGenerate', 'args' => ['dayOfMonth']],
        'default' => ['factory' => 'makeGenerate', 'args' => ['dayOfWeek']],
    ],
    'month'     => [
        'month'   => ['factory' => 'makeGenerate', 'args' => ['monthName']],
        'default' => ['factory' => 'makeGenerate', 'args' => ['month']],
    ],
    'year'      => [
        'default' => ['factory' => 'makeGenerate', 'args' => ['year']],
    ],
    'century'   => [
        'default' => ['factory' => 'makeGenerate', 'args' => ['century']],
    ],
    'hash'      => [
        'md5'     => ['factory' => 'makeGenerate', 'args' => ['md5']],
        'sha1'    => ['factory' => 'makeGenerate', 'args' => ['sha1']],
        'sha256'  => ['factory' => 'makeGenerate', 'args' => ['sha256']],
        'default' => ['factory' => 'makeGenerate', 'args' => ['md5']],
    ],
    'md5'       => [
        'default' => ['factory' => 'makeGenerate', 'args' => ['md5']],
    ],
    'sha1'      => [
        'default' => ['factory' => 'makeGenerate', 'args' => ['sha1']],
    ],
    'sha256'    => [
        'default' => ['factory' => 'makeGenerate', 'args' => ['sha256']],
    ],
    'language'  => [
        'default' => ['factory' => 'makeGenerate', 'args' => ['languageCode']],
    ],
    'mime'      => [
        'default' => ['factory' => 'makeGenerate', 'args' => ['mimeType']],
    ],
    'uuid'      => [
        'default' => ['factory' => 'makeGenerate', 'args' => ['uuid']],
    ],
    'id'        => [
        'default' => ['factory' => 'makeGenerate', 'args' => ['numberBetween(100, 50000)']],
    ],
    'extension' => [
        'default' => ['factory' => 'makeGenerate', 'args' => ['fileExtension']],
    ],
    'ip'        => [
        'v4'      => ['factory' => 'makeGenerate', 'args' => ['ipv4']],
        'v6'      => ['factory' => 'makeGenerate', 'args' => ['ipv6']],
        'default' => ['factory' => 'makeGenerate', 'args' => ['ipv4']],
    ],
    'mac'       => [
        'default' => ['factory' => 'makeGenerate', 'args' => ['macAddress']],
    ],
    'ean'       => [
        '8'       => ['factory' => 'makeGenerate', 'args' => ['ean8']],
        '13'      => ['factory' => 'makeGenerate', 'args' => ['ean13']],
        'default' => ['factory' => 'makeGenerate', 'args' => ['ean13']],
    ],
    'isbn'      => [
        '10'      => ['factory' => 'makeGenerate', 'args' => ['isbn10']],
        '13'      => ['factory' => 'makeGenerate', 'args' => ['isbn13']],
        'default' => ['factory' => 'makeGenerate', 'args' => ['isbn13']],
    ],
];
