<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use CSearchFullText;

Loader::includeModule("iblock");
Loader::includeModule("search");
Loader::includeModule("catalog");

$request = \Bitrix\Main\Context::getCurrent()->getRequest();

$arResult['catalog'] = \Bitrix\Catalog\CatalogIblockTable::getList()->fetchAll();
$catalog_ids = array_map(function ($array) {
    return $array['IBLOCK_ID'];
}, $arResult['catalog']);

$arResult['iblock'] = \Bitrix\Iblock\IblockTable::getList([
    'filter' => ['INDEX_ELEMENT' => 'Y', '!ID' => $catalog_ids]
])->fetchAll();
$iblock_ids = array_map(function ($array) {
    return $array['ID'];
}, $arResult['iblock']);

$arResult['param_name_query'] = ($arParams['PARAM_NAME_QUERY']?: 'q');
$arResult['query'] = trim($request->get($arResult['param_name_query']));

if ($arResult['query']) {
    $APPLICATION->SetTitle("Результаты по запросу «" . $arResult['query'] . "»");

    $searches = [
        'static' => [
            'params' => [
                'QUERY' => $arResult['query'],
                'MODULE_ID' => 'main'
            ]
        ],
        'iblock' => [
            'params' => [
                'QUERY' => $arResult['query'],
                'MODULE_ID' => 'iblock',
                'PARAM2' => $iblock_ids
            ]
        ],
        'catalog' => [
            'params' => [
                'QUERY' => $arResult['query'],
                'MODULE_ID' => 'iblock',
                'PARAM2' => $catalog_ids
            ]
        ],
    ];
    foreach ($searches as $key => $search){
        $arResult['items'][$key] = [];
        $obSearch = new CSearch;
        $obSearch->SetOptions(['ERROR_ON_EMPTY_STEM' => false]);
        $obSearch->Search($search['params']);
        if (!$obSearch->selectedRowsCount()) {
            $obSearch->Search(
                $search['params'], [], ['STEMMING' => false]);
        }
        while ($ar = $obSearch->fetch()) {
            $arResult['items'][$key][$ar['ITEM_ID']] = $ar;
        }

        $arResult['count'][$key] = $obSearch->selectedRowsCount();
        $arResult['total_count'] += $obSearch->selectedRowsCount();
    }


    $ids = array_keys($arResult['items']['catalog']) ?: '-1';
    $rs = CIBlockElement::GetList([], ["ID" => $ids], false, [], ["ID", "IBLOCK_ID", "NAME", "catalog_QUANTITY", "DETAIL_PAGE_URL", "PREVIEW_PICTURE", "DETAIL_PICTURE", "CATALOG_PRICE_*", "CATALOG_GROUP_*"]);
    while ($ar = $rs->GetNext()) {
        $ar["PREVIEW_PICTURE"] = CFile::GetFileArray($ar["PREVIEW_PICTURE"]);
        $ar["DETAIL_PICTURE"] = CFile::GetFileArray($ar["DETAIL_PICTURE"]);
        $arResult['items']['catalog'][$ar['ID']] = array_merge($arResult['items']['catalog'][$ar['ID']], $ar);
    }

    $ids = array_keys($arResult['items']['iblock']) ?: '-1';
    $rs = CIBlockElement::GetList([], ["ID" => $ids], false, [], ["ID", "IBLOCK_ID", "DETAIL_PAGE_URL", "PREVIEW_PICTURE", "DETAIL_PICTURE"]);
    while ($ar = $rs->GetNext()) {
        $ar["PREVIEW_PICTURE"] = CFile::GetFileArray($ar["PREVIEW_PICTURE"]);
        $ar["DETAIL_PICTURE"] = CFile::GetFileArray($ar["DETAIL_PICTURE"]);
        $arResult['items']['iblock'][$ar['ID']] = array_merge($arResult['items']['iblock'][$ar['ID']], $ar);
    }
}

//print_pre($arResult);

$this->IncludeComponentTemplate();
