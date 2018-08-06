<?php
/**
 * Created by PhpStorm.
 * User: magestro
 * Date: 12.10.2016
 * Time: 17:44
 */

namespace Astronim;

use Bitrix\Iblock\ElementTable;
use \Bitrix\Iblock\IblockTable;
use Bitrix\Main\Application;
use Bitrix\Main\Context;
use \Bitrix\Main\Loader;
use Bitrix\Main\Web\Uri;

class Helper
{
    const include_absolute_path = "#ROOT##SITE_DIR#local/include/#SITE_ID#/#PATH#";
    const include_web_path = "#SITE_DIR#local/include/#SITE_ID#/#PATH#";
    private static $CONTENT = [];

    public static function getChainBg()
    {
        Loader::includeModule('iblock');
        global $APPLICATION;
        $iblock_id = 10;
        $page = $APPLICATION->GetCurPage();
        do {
            $rs = ElementTable::getList([
                'filter' => ['NAME' => $page, 'IBLOCK_ID' => $iblock_id],
                'limit' => 1,
                'select' => ['PREVIEW_PICTURE']
            ]);
            if(($pos = strrpos($page, '/')) !== false){
                if($pos == strlen($page) - 1){
                    $page = substr($page, 0, $pos);
                    $pos = strrpos($page, '/');
                }
                $page = substr($page, 0, $pos + 1);
            }
        } while (!$rs || $page);

        if ($ar = $rs->fetch()) {
            return \CFile::GetFileArray($ar['PREVIEW_PICTURE']);
        }

        return false;
    }

    public static function includeFile($path, $options = [], $params = [])
    {
        if (!$path) return false;
        //change any extension to php
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        if (strlen($extension) > 0) {
            $path = substr($path, 0, -strlen(pathinfo($path, PATHINFO_EXTENSION)));
        }
        $path .= '.php';

        $absolute_path = self::replaceAnchors(self::include_absolute_path, ['#PATH#' => $path]);

        //remove bitrix include header and footer
        $dir_path = explode('/', $absolute_path);
        array_pop($dir_path);
        $dir_path = implode('/', $dir_path);

        if (!is_dir($dir_path))
            mkdir($dir_path, 0775, true);

        if (!file_exists($absolute_path))
            touch($absolute_path);

        $web_path = self::replaceAnchors(self::include_web_path, ['#PATH#' => $path]);
        if (empty($options)) $options = [];
        else {
            foreach ($options as $key => $val) {
                $val = is_bool($val) ? $val : strtolower($val);
                $options[strtoupper($key)] = $val;
            }
        }

        global $APPLICATION;
        $APPLICATION->IncludeFile($web_path, $params, $options);
    }


    public static function getIblockIdByCode($code, $type_id = "")
    {
        Loader::IncludeModule('iblock');

        $filter = [
            'CODE' => $code
        ];

        if ($type_id)
            $filter['IBLOCK_TYPE_ID'] = $type_id;

        return IblockTable::getList(array(
            'select' => ['ID'],
            'filter' => $filter,
            'limit' => 1
        ))->fetch() ['ID'];
    }


    public static function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }


    public static function replaceAnchors($str, array $additional = [])
    {

        $replace = [
            '#ROOT#' => Application::getDocumentRoot(),
            '#SITE_DIR#' => SITE_DIR, //todo d7
            '#SITE_ID#' => Context::getCurrent()->getSite(),
        ];

        if (!empty($additional))
            $replace = array_merge($replace, $additional);

        return str_replace(array_keys($replace), array_values($replace), $str);

    }


    public static function showContent($name)
    {
        global $APPLICATION;
        $APPLICATION->AddBufferContent([__CLASS__, 'getContent'], $name);

    }

    public static function addContent($name, $content, $merge = true)
    {
        if($merge)
            self::$CONTENT[$name] .= $content;
        else
            self::$CONTENT[$name] = $content;
    }

    public static function getContent($name)
    {
        return self::$CONTENT[$name];
    }


    public static function getClosestElements($id, $arParams)
    {
        Loader::includeModule('iblock');

        $sort = array($arParams['SORT_BY1'] => $arParams['SORT_ORDER1'], $arParams['SORT_BY2'] => $arParams['SORT_ORDER2'],
            'ID' => 'DESC'//it's default conduct for news.list component
        );
        $filter = array(
            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
            'ACTIVE' => 'Y',
            'DATE_ACTIVE' => 'Y'
        );
        $select = array('ID', 'NAME', 'ACTIVE_FROM', 'PREVIEW_PICTURE', 'DETAIL_PAGE_URL');
        $rs = \CIBlockElement::GetList(
            $sort,
            $filter,
            false,
            array('nPageSize' => 1, 'nElementID' => $id),
            $select
        );
        $nearest = [];
        while ($ar = $rs->GetNext()) {
            $ar['PREVIEW_PICTURE'] = \CFile::GetFileArray($ar['PREVIEW_PICTURE']);
            $nearest[] = $ar;
        }
        if (count($nearest) == 3) {
            $return['prev'] = $nearest[0];
            $return['next'] = $nearest[2];
        } elseif (count($nearest) == 2) {
            if ($nearest[0]['ID'] == $id) {
                $return['prev'] = false;
                $return['next'] = $nearest[1];
            } else {
                $return['prev'] = $nearest[0];
                $return['next'] = false;
            }
        } else {
            $return['prev'] = false;
            $return['next'] = false;
        }

        return $return;
    }


    public static function getShareUrl($service = null)
    {
        $request = Context::getCurrent()->getRequest();
        $current_url = "http://" . $request->getHttpHost() . $request->getRequestUri();
        switch ($service) {
            case "vk":
                $url = "https://vk.com/share.php?url=".urlencode($current_url);
                break;
            case "facebook":
                $url = "https://www.facebook.com/sharer/sharer.php?u=".urlencode($current_url);
                break;
            case "ok":
                $url = "https://connect.ok.ru/offer?url=".urlencode($current_url);
                break;
            case "twitter":
                $url = "https://twitter.com/intent/tweet?url=".urlencode($current_url);
                break;
            default:
                $url = urlencode($current_url);
                break;
        }

        return $url;
    }
}