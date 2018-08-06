<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$rs = \Bitrix\Iblock\PropertyEnumerationTable::getList([
    'filter' => ['PROPERTY.IBLOCK_ID' => $arParams['IBLOCK_ID'], 'PROPERTY.CODE' => 'type'],
    'select' => ['VALUE', 'SORT', 'XML_ID', 'DEF'],
    'order' => ['SORT' => 'asc']
]);
while($ar = $rs->fetch()){
    $arResult['ITEMS_BY_TYPE'][$ar['XML_ID']] = $ar;
}
foreach($arResult["ITEMS"] as &$arItem){
    if($type = $arItem['PROPERTIES']['type']['VALUE_XML_ID']){
        if(!is_array($arResult['ITEMS_BY_TYPE'][$type]['ITEMS'])){
            $arResult['ITEMS_BY_TYPE'][$type]['ITEMS'] = [];
        }
        $arResult['ITEMS_BY_TYPE'][$type]['ITEMS'][] = $arItem;
    }
}