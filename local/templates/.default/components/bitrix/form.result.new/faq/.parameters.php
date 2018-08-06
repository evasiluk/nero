<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arCurrentValues */
if (!\Bitrix\Main\Loader::includeModule("form"))
    return;

$arQuestions = [];
$rs = CFormField::GetList(
    $arCurrentValues['WEB_FORM_ID'],
    "ALL",
    $by="s_sort",
    $order="asc",
    [],
    $is_filtered
);
while ($ar = $rs->Fetch())
{
//    $arTemplateParameters[$ar['ID'] . '_VALUE'] = [
//        "PARENT" => "BASE",
//        "NAME" => $ar['TITLE'],
//        "TYPE" => "STRING"
//    ];

}