<?php
$items = array();
//print_pre($arResult["ITEMS"]);

foreach($arResult["ITEMS"] as $i=>$arItem) {


    if(SITE_ID == "s1") {
        $file = CFile::GetByID($arItem["PROPERTIES"]["FILE_RU"]["VALUE"]);
        $size = round($file->arResult[0]["FILE_SIZE"] /(1024*1024), 2)." MB";
        $link = CFile::GetPath($arItem["PROPERTIES"]["FILE_RU"]["VALUE"]);
    } else {
        $file = CFile::GetByID($arItem["PROPERTIES"]["FILE_EN"]["VALUE"]);
        $size = round($file->arResult[0]["FILE_SIZE"] /(1024*1024), 2)." MB";
        $link = CFile::GetPath($arItem["PROPERTIES"]["FILE_EN"]["VALUE"]);
    }


    $type = "";

    if(strpos($link, ".doc")) {
        $type = "doc";
    }
    if(strpos($link, ".xlsx")) {
        $type = "xls";
    }
    if(strpos($link, ".pdf")) {
        $type = "pdf";
    }

    $items[$i]["DATE"] = $arItem["ACTIVE_FROM"];
    $items[$i]["SIZE"] = $size;
    $items[$i]["LINK"] = $link;
    $items[$i]["NAME"] = (SITE_ID == "s1")? $arItem["NAME"] : $arItem["PROPERTIES"]["NAME_EN"]["VALUE"];
    $items[$i]["TYPE"] = $type;

}
//print_pre($arResult["ITEMS"]);
$arResult["ITEMS"] = $items;