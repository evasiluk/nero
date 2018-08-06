<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
//print_pre($arResult);
foreach($arResult["ITEMS"] as &$arItem){
    if($arItem['PROPERTIES']['video']['VALUE'])
        $arItem['PROPERTIES']['video']['VALUE'] = CFile::GetFileArray($arItem['PROPERTIES']['video']['VALUE']);
}