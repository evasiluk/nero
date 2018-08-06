<?php
/**
 * Created by PhpStorm.
 * User: magestro
 * Date: 12.10.2016
 * Time: 17:44
 */

namespace Astronim\Region;

use Bitrix\Iblock\ElementTable;
use \Bitrix\Iblock\IblockTable;
use Bitrix\Main\Application;
use Bitrix\Main\Context;
use \Bitrix\Main\Loader;
use Bitrix\Main\Web\Uri;

class RegionController
{
    const SESSION_KEY_CURRENT_REGION = 'user_current_region';
    const REQUEST_KEY_CURRENT_REGION = 'set_region';

    private static $instance = null; //sry for that but bitrix has not any global container, so i can't use DI manually

    private $regions = [];
    private $currentRegion;

    /**
     * RegionController constructor.
     * @throws \Bitrix\Main\LoaderException
     */
    public function __construct()
    {
        Loader::includeModule('iblock');
        $this->fillRegions();
        $this->currentRegion = $this->guessRegion();
        $this->setCurrentRegionToSession();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function fillRegions()
    {
        $rs = ElementTable::getList(['filter' => ['IBLOCK_ID' => Region::getIblockId()], 'select' => ['ID', 'CODE'], 'order' => ['SORT' => 'asc']]);
        while ($ar = $rs->fetch()) {
            $this->regions[$ar['CODE']] = new Region($ar['ID']);
        }
    }

    /**
     * @return Region|bool
     */
    public function guessRegion()
    {
        if ($region = $this->getFromRequest())
            return $region;

        if ($region = $this->getByIp())
            return $region;

        if ($region = $this->getFromSession())
            return $region;

        return $this->getDefaultRegion();
    }

    /**
     * @param Region $region
     * @return Uri
     */
    public function getSwitchRegionUri(Region $region)
    {
        $uri = new Uri($this->getRequest()->getRequestUri());

        $uri->addParams([self::REQUEST_KEY_CURRENT_REGION => $region->getField('CODE')]);
        return $uri;
    }

    /**
     * @return \Bitrix\Main\HttpRequest
     */
    public function getRequest()
    {
        return Context::getCurrent()->getRequest();
    }

    /**
     * @return Region|mixed
     */
    private function getDefaultRegion()
    {
        /** @var Region $region */
        foreach ($this->regions as $region) {
            if ($region->getProperty('is_default'))
                return $region;
        }

        return first($this->regions);
    }

    /**
     * @param $code
     * @return Region|bool
     */
    public function getRegionByCode($code)
    {
        return $this->regions[$code] ?: false;
    }

    /**
     * @return Region|bool
     */
    private function getFromRequest()
    {
        if (($regionKey = $_REQUEST[self::REQUEST_KEY_CURRENT_REGION]) !== null) {
            return $this->getRegionByCode($regionKey);
        }

        return false;
    }

    /**
     * @return Region|bool
     */
    private function getFromSession()
    {
        if (($regionKey = $_SESSION[self::SESSION_KEY_CURRENT_REGION]) !== null) {
            return self::getRegionByCode($regionKey);
        }

        return false;
    }

    /**
     * @return array
     */
    public function getRegions()
    {
        return $this->regions;
    }

    /**
     * @return Region|bool|mixed
     */
    public function getCurrentRegion()
    {
        return $this->currentRegion;
    }

    /**
     *
     */
    private function setCurrentRegionToSession()
    {
        $_SESSION[self::SESSION_KEY_CURRENT_REGION] = $this->getCurrentRegion()->getField('CODE');
    }

    private function getByIp()
    {
        //todo
        return false;
    }
}