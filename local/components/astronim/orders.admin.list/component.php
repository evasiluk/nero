<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
use Bitrix\Main\Loader,
    Bitrix\Sale\Internals\OrderTable,
    Bitrix\Sale\Internals\StatusTable;

Loader::includeModule('sale');
$request = \Bitrix\Main\Context::getCurrent()->getRequest();


// мой код
$manager_groups = CUser::GetUserGroup(CUser::GetID());
$class = new managersClass();

$manager_code = $class->get_manager_code($manager_groups);
$dealers_groups = $class->get_dilers_groups($manager_code);

//добавили и розничных покупателей - раньше не надо было
$rosn_groups = $class->get_rosn_groups($manager_code);
$dealers_groups = array_merge($dealers_groups, $rosn_groups);

$dealers = $class->get_active_dealers_list($dealers_groups);

$dealers_ids = array();

foreach($dealers as $us) {
    $dealers_ids[] = $us["ID"];
}

//мой код конец





//todo
if(!function_exists('getOrderValues')){
    function getOrderValues($order_id)
    {
        \CModule::IncludeModule("sale");
        $return = [];

        $rs = \Bitrix\Sale\Internals\OrderPropsValueTable::getList([
            'filter' => ['ORDER_ID' => $order_id],
            'select' => ['CODE', 'VALUE']
        ]);
        while ($ar = $rs->fetch()) {
            $return[$ar['CODE']] = $ar['VALUE'];
        }

        return $return;
    }
}

// sorter
$arResult['orders'] = [
    'date' => [
        'name' => 'Дата',
        'by' => 'DATE_INSERT',
        'default' => 'desc'
    ],
    'status' => [
        'name' => 'Статус',
        'by' => 'STATUS_ID',
        'default' => 'desc'
    ],
    'user' => [
        'name' => 'Пользователь',
        'by' => 'USER.LOGIN',
        'default' => 'asc'
    ],
//    'document_name' => [
//        'name' => 'Наименование документа',
//        'by' => [
//            '=BASKET.Bitrix\Sale\Internals\BasketPropertyTable:BASKET.CODE' => 'order_document_name',
//            'BASKET.Bitrix\Sale\Internals\BasketPropertyTable:BASKET.VALUE'
//        ],
//        'default' => 'asc'
//    ],
//    'document_author' => [
//        'name' => 'Автору документа',
//        'by' => 'BASKET.Bitrix\Sale\Internals\BasketPropertyTable:BASKET.CODE',
//        'default' => 'asc'
//    ]
];

$current_order = ($arResult['orders'][$request->get('order')] ?: $arResult['orders']['date']);

$order_by = $request->get('by') ?: $current_order['default'];
$reverse_order_by = $order_by == 'asc' ? 'desc' : 'asc';

$order_url = new \Bitrix\Main\Web\Uri($request->getRequestUri());
$order_url->addParams(['by' => $reverse_order_by]);


foreach ($arResult['orders'] as $key => &$item){
    $order_url->addParams(['order' => $key]);
    if($current_order['by'] == $item['by']){
        $order_url->addParams(['by' => $reverse_order_by]);
        $item['order'] = $order_by;
        $item['current'] = true;
    } else {
        $order_url->addParams(['by' => $item['default']]);
        $item['order'] = $item['default'];
    }

    $item['link'] =  $order_url->getUri();
}
$order = [$current_order['by'] => $order_by];
// \sorter

//$rs = \CSaleOrder::GetList([],['LID' => SITE_ID], false, ['nPageSize' => 10]);
//while($ar = $rs->GetNext()){

$arResult['nav'] = new \Bitrix\Main\UI\PageNavigation("orders");
$arResult['nav']
    ->allowAllRecords($arParams['PAGER_SHOW_ALL'] == "Y")
    ->setPageSize(10)
    ->initFromUri();

$filter = [];
if($id = (int) $arParams['ID']){
    $filter['BASKET.PRODUCT.ID'] = $id;
}
$filter['LID'] = SITE_ID;
$filter['LOGIC'] = 'AND';

//фильтруем только заказы дилеров конкретного манагера
$filter["USER_ID"] = $dealers_ids;

if(is_array($GLOBALS[$arParams['FILTER_NAME']]))
    $filter = array_merge($filter, $GLOBALS[$arParams['FILTER_NAME']]);
$rs = OrderTable::getList([
    "filter" => $filter,
    "offset" => $arResult['nav']->getOffset(),
    "limit" => $arResult['nav']->getLimit(),
    "order" => $order,
    'count_total' => true
//    "cache" => ["ttl" => 3600]
]);
$arResult['nav']->setRecordCount($rs->getCount());
while ($ar = $rs->fetch()) {
    $ar['PROPS'] = getOrderValues($ar['ID']);

//in actual content only one item in order
    $ar['BASKET'] = \CSaleBasket::GetList([], ["ORDER_ID" => $ar["ID"]])->GetNext();

    $rsBasketProps = \CSaleBasket::GetPropsList([], ["BASKET_ID" => $ar['BASKET']['ID']]);
    while ($arBasketProp = $rsBasketProps->GetNext()) {
        $ar['BASKET']['PROPS'][$arBasketProp['CODE']] = $arBasketProp;
    }

    $ar['USER'] = \CUser::GetByID($ar['USER_ID'])->GetNext();

    $ar['DETAIL_URL'] = str_replace("#ID#", $ar['ID'], $arParams['DETAIL_URL']);

    $arResult['ORDERS'][] = $ar;

}

$rs = StatusTable::getList([
    'select' => array(
        'ID',
        'SORT',
        'LID' => 'Bitrix\Sale\Internals\StatusLangTable:STATUS.LID',
        'NAME' => 'Bitrix\Sale\Internals\StatusLangTable:STATUS.NAME',
        'DESCRIPTION' => 'Bitrix\Sale\Internals\StatusLangTable:STATUS.DESCRIPTION'
    ),
    'filter' => [
        '=Bitrix\Sale\Internals\StatusLangTable:STATUS.LID' => LANGUAGE_ID,
        '=TYPE' => 'O'
    ]
]);
while($ar = $rs->fetch()){
   $arResult['STATUS'][$ar['ID']] = $ar;
}

$this->IncludeComponentTemplate();
