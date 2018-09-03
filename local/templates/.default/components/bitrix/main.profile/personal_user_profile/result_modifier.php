<?
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

?>