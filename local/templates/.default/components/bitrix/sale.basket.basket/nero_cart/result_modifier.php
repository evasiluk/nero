<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
use Bitrix\Main;

$defaultParams = array(
	'TEMPLATE_THEME' => 'blue'
);
$arParams = array_merge($defaultParams, $arParams);
unset($defaultParams);

$arParams['TEMPLATE_THEME'] = (string)($arParams['TEMPLATE_THEME']);
if ('' != $arParams['TEMPLATE_THEME'])
{
	$arParams['TEMPLATE_THEME'] = preg_replace('/[^a-zA-Z0-9_\-\(\)\!]/', '', $arParams['TEMPLATE_THEME']);
	if ('site' == $arParams['TEMPLATE_THEME'])
	{
		$templateId = (string)Main\Config\Option::get('main', 'wizard_template_id', 'eshop_bootstrap', SITE_ID);
		$templateId = (preg_match("/^eshop_adapt/", $templateId)) ? 'eshop_adapt' : $templateId;
		$arParams['TEMPLATE_THEME'] = (string)Main\Config\Option::get('main', 'wizard_'.$templateId.'_theme_id', 'blue', SITE_ID);
	}
	if ('' != $arParams['TEMPLATE_THEME'])
	{
		if (!is_file($_SERVER['DOCUMENT_ROOT'].$this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css'))
			$arParams['TEMPLATE_THEME'] = '';
	}
}
if ('' == $arParams['TEMPLATE_THEME'])
	$arParams['TEMPLATE_THEME'] = 'blue';




//
$iblock_id = 30;
switch($_SERVER["HTTP_HOST"]) {
    case BY_HOST: $iblock_id = 30;
        break;
    case UA_HOST : $iblock_id = 58;
        break;
    case SPB_HOST : $iblock_id = 59;
        break;
    case MSK_HOST : $iblock_id = 60;
        break;
}



$arResult["TOTAL_ITEMS_COUNT"] = count($arResult["GRID"]["ROWS"]);
$arResult["VALUTE_SHORT"] = get_valute_short($iblock_id);
$arResult["DISCOUNT"] = 0;

$arResult["BASKET_ITEMS"] = array();

foreach($arResult["GRID"]["ROWS"] as &$arItem) {
    $arSelect = Array("ID", "NAME", "PROPERTY_COLOR_CODE");
    $arFilter = Array("ID" => $arItem["PRODUCT_ID"]);

    $dbEl = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    $element = array();

    while($obEl = $dbEl->GetNextElement()) {
        $arFields = $obEl->GetFields() ;
        $arItem["COLOR_CODE"] = $arFields["PROPERTY_COLOR_CODE_VALUE"];
    }

    $arResult["DISCOUNT"] = $arItem["DISCOUNT_PRICE_PERCENT"];

    $arItem["FULL_PRICE"] = convert_valute($arItem["FULL_PRICE"], $iblock_id);
    $arItem["PRICE"] = convert_valute($arItem["PRICE"], $iblock_id);

    $arResult["BASKET_ITEMS"][] = $arItem;
}

