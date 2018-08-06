<?php
/**
 * Created by PhpStorm.
 * User: magestro
 * Date: 12.10.2016
 * Time: 17:44
 */

namespace Astronim\Region;

use Astronim\AbstractIblockElement;
use Bitrix\Iblock\ElementTable;
use \Bitrix\Iblock\IblockTable;
use Bitrix\Main\Application;
use Bitrix\Main\Context;
use \Bitrix\Main\Loader;
use Bitrix\Main\Web\Uri;

class Region extends AbstractIblockElement implements RegionInterface
{
    public static function getIblockId()
    {
        switch (SITE_ID){
            case 's1':
            default:
                return 28;
                break;
        }
    }
}