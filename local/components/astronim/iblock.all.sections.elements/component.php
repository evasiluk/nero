<?php
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
use Bitrix\Main\Loader;

if(!function_exists('getItemProperties')){
    function getItemProperties($id, $iblock_id)
    {
        $properties = [];
        $rs = \CIBlockElement::GetProperty($iblock_id, $id);
        while ($ar = $rs->Fetch()) {
            if(!$properties[$ar['CODE']])
                $properties[$ar['CODE']] = $ar;

            if ($ar['PROPERTY_TYPE'] == 'L') {
                $value = $ar['VALUE_XML_ID'];
            } else {
                $value = $ar['VALUE'];
            }


            if ($ar['MULTIPLE'] == 'Y') {
                if(!is_array($properties[$ar['CODE']]['VALUE'])){
                    $properties[$ar['CODE']]['VALUE'] = [];
                }
                $properties[$ar['CODE']]['VALUE'][] = $value;
            } else {
                $properties[$ar['CODE']]['VALUE'] = $value;
            }
        }

        return $properties;
    }
}
if(!function_exists('getSectionItems')){
    function getSectionItems($id, $iblock_id)
    {
        $items = [];
        $rsItem = CIBlockElement::GetList([], [
            'IBLOCK_ID' => $iblock_id,
            'ACTIVE' => 'Y',
            'IBLOCK_SECTION_ID' => $id
        ], false, false, [
            '*'
        ]);
        while($arItem = $rsItem->Fetch()) {
            $arItem['PROPERTIES'] = getItemProperties($arItem['ID'], $iblock_id);

            $items[] = $arItem;
        }

        return $items;
    }
}

if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
if(!Loader::includeModule('iblock')){
    ShowError("Error");
    return;
}

$arResult['IBLOCK']['ID'] = $arParams['IBLOCK_ID'];
$arResult['IBLOCK']['TYPE_ID'] = $arParams['IBLOCK_TYPE_ID'];

$arResult['IBLOCK'] = \Bitrix\Iblock\IblockTable::getList([
    'filter' => [
        'ID' => $arParams['IBLOCK_ID']
    ]
])->fetch();
if(!$arResult['IBLOCK']){
    ShowError("Wrong iblock ID");
    return;
}

$rsSection = CIBlockSection::GetList([], [
    'IBLOCK_ID' => $arResult['IBLOCK']['ID'],
    'ACTIVE' => 'Y'
], false, [
    '*', 'UF_*'
]);
while($arSection = $rsSection->Fetch()){
    $arResult['SECTIONS'][$arSection['ID']] = $arSection;
    $arResult['SECTIONS'][$arSection['ID']]['ITEMS'] = getSectionItems($arSection['ID'], $arResult['IBLOCK']['ID']);
}
$this->IncludeComponentTemplate();
