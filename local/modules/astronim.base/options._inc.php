<?php
namespace Astronim;
defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();
use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Text\String;
$options = [
    'DEFAULT' => [
        'text' => [
            'type' => 'text'
        ],
        'text_multiple' => [
            'type' => 'text',
            'multiple' => true,
            'default' => 'ololo'
        ],

        'select' => [
            'type' => 'select',
            'default' => 2,
            'values' => [1 => 'one', 2 => 'two', 3 => 'three'],
        ],
        'select_multiple' => [
            'type' => 'select',
            'multiple' => true,
            'default' => [1, 2],
            'values' => [1 => 'one', 2 => 'two', 3 => 'three'],
        ],

        'textarea' => [
            'type' => 'textarea',
            'default' => "sometext\nmoretext"
        ],

        'static' => [
            'type' => 'static',
            'value' => 'static'
        ],

        'title' => [
            'type' => 'title',
            'value' => 'title'
        ],
    ]
];

return $options;