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
$iblock_id = get_region_catalog_iblock();
$arResult["VALUTE_SHORT"] = get_valute_short($iblock_id);

$class = new neroCatalogClass();
$dealer = $class->is_dealer(CUser::GetUserGroup(CUser::GetID()));




$arResult["TOTAL_ITEMS_COUNT"] = 0;
$arResult["TOTAL_SUM"] = 0;
$arResult["TOTAL_SUM_DISCOUNT"] = 0;
$arResult["TOTAL_DEALER_SAVINGS"] = 0;


$arResult["BASKET_ITEMS"] = array();

foreach($arResult["GRID"]["ROWS"] as &$arItem) {
    $arSelect = Array("ID", "NAME", "PROPERTY_COLOR_CODE");
    if($dealer) {
        $arSelect[] = "CATALOG_GROUP_7";
    }
    $arFilter = Array("ID" => $arItem["PRODUCT_ID"]);

    $dbEl = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    $element = array();

    while($obEl = $dbEl->GetNextElement()) {
        $arFields = $obEl->GetFields() ;

        if($arFields["CATALOG_PRICE_7"]) {
            $arItem["ROSN_PRICE"] = convert_valute($arFields["CATALOG_PRICE_7"], $iblock_id);
            $arItem["ROSN_PRICE_SUM"] = $arItem["ROSN_PRICE"] * $arItem["QUANTITY"];
        }

        $arItem["COLOR_CODE"] = $arFields["PROPERTY_COLOR_CODE_VALUE"];
    }

    $arItem["FULL_PRICE"] = convert_valute($arItem["FULL_PRICE"], $iblock_id);  // без скидки
    $arItem["FULL_PRICE_SUM"] = $arItem["FULL_PRICE"] * $arItem["QUANTITY"];

//    $arItem["PRICE"] = convert_valute($arItem["PRICE"], $iblock_id);   // со скидкой


    $arResult["TOTAL_SUM"] += $arItem["FULL_PRICE_SUM"];
    $arResult["TOTAL_SUM_DISCOUNT"] += convert_valute($arItem["SUM_DISCOUNT_PRICE"], $iblock_id);
    $arResult["TOTAL_ITEMS_COUNT"] += $arItem["QUANTITY"];

    if($dealer) {
        $arResult["TOTAL_DEALER_SAVINGS"] += $arItem["ROSN_PRICE_SUM"] - $arItem["FULL_PRICE_SUM"];
    }

    $arResult["BASKET_ITEMS"][] = $arItem;
}

$arResult["FINAL_SUM"] = $arResult["TOTAL_SUM"] - $arResult["TOTAL_SUM_DISCOUNT"];

if($dealer) {
    $arResult["TOTAL_DEALER_SAVINGS"] = number_format( $arResult["TOTAL_DEALER_SAVINGS"] + $arResult["TOTAL_SUM_DISCOUNT"], 2, '.', '');
}







// накопительная скидка для пользователя
use Bitrix\Main\Loader,
    \Astronim\Dealer,
    Bitrix\Iblock\ElementTable;

global $USER;
$arGroups = CUser::GetUserGroup($USER->GetID());


CModule::IncludeModule("sale");
$db_res = CSaleDiscount::GetList(
    array("SORT" => "ASC"),
    array(
        "LID" => SITE_ID,
        "ACTIVE" => "Y",
        "USER_GROUPS" => $arGroups, // фильтруем по группам

    ),
    false,
    false,
    array()
);

$discount = array();

if ($ar_res = $db_res->Fetch())
{
    $discount = $ar_res;
}




function getCumulativeDiscount($discount_id)
{
    $discount = 0;
    //$cumulativeDiscountId = 1; // id накопительной скидки
    $cumulativeDiscountId = $discount_id;

    if (Loader::includeModule("sale")) {
        global $USER;
        $cumulativeCalc = new Bitrix\Sale\Discount\CumulativeCalculator($USER->GetID(), SITE_ID);
        // сумма всех оплаченных заказов.
        $orderSum = $cumulativeCalc->calculate();

        $arCumulativeDiscount = CSaleDiscount::GetByID($cumulativeDiscountId);
        $arDiscountRanges = unserialize($arCumulativeDiscount['ACTIONS'])['CHILDREN'][0]['DATA']['ranges'];
        //ищем попадание суммы оплаченных заказов в интервалы  скидок
        foreach ($arDiscountRanges as $arRange) {
            if ($orderSum >= $arRange['sum']) {
                if ($arRange['type'] == 'P') {
                    $discount =  $arRange['value'].'%';
                } else {
                    $discount =  $arRange['value'].' руб.';
                }
            }
        }
    }

    return $discount;
}

if($discount["ID"]) {
    $dis = getCumulativeDiscount($discount["ID"]);
    $arResult["USER_DISCOUNT"] = $dis;
}

