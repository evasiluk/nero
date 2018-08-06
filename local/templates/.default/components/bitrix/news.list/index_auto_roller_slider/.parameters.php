<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();


$arIBlocks=array();
$db_iblock = CIBlock::GetList(array("SORT"=>"ASC"), array("SITE_ID"=>$_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"]!="-"?$arCurrentValues["IBLOCK_TYPE"]:"")));
while($arRes = $db_iblock->Fetch())
    $arIBlocks[$arRes["ID"]] = "[".$arRes["ID"]."] ".$arRes["NAME"];

$arTemplateParameters = array(
    "IBLOCK_ID" => array(
        "PARENT" => "BASE",
        "NAME" => "ID связанного инфоблока",
        "TYPE" => "LIST",
        "VALUES" => $arIBlocks,
        "DEFAULT" => '={$_REQUEST["ID"]}',
        "ADDITIONAL_VALUES" => "Y",
        "REFRESH" => "Y",
    ),
);
?>
