<?php

namespace Astronim;

use Bitrix\Main\Application;
use Bitrix\Main\Loader as Loader;
use Bitrix\Iblock\ElementTable as ElementTable;
use Bitrix\Iblock\PropertyTable as PropertyTable;

class Dealer extends AbstractIblockElement
{
    /**
     * @return int $iblock_id
     */
    public static function getIblockId(){
        return 20;
    }

}