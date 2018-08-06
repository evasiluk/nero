<?php
namespace Astronim;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;

Loader::includeModule('iblock');
Loader::includeModule('sale');

class Base
{
    public static $MODULE_ID = 'astronim.base';

    public static function getOption($name, $default = '', $site_id = false)
    {
        return Option::get(self::$MODULE_ID, $name, $default, $site_id);
    }

    public static function setOption($name, $value, $site_id = false)
    {
        Option::set(self::$MODULE_ID, $name, $value, $site_id);
    }

}