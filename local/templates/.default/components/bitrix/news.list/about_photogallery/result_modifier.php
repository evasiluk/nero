<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

foreach($arResult['ITEMS'] as &$arItem){
    foreach ($arItem['PROPERTIES']['photo']['VALUE'] as &$fid){
        $fid = CFile::GetFileArray($fid);
    }
}