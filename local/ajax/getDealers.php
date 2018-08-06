<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader,
    \Astronim\Dealer,
    Bitrix\Iblock\ElementTable;

$iblock_id = 20;
Loader::includeModule('iblock');
$request = \Bitrix\Main\Context::getCurrent()->getRequest();
$result = [];

$rs = ElementTable::getList([
    'filter' => [
        'IBLOCK_ID' => $iblock_id,
        'ACTIVE' => 'Y'
    ],
    'select' => ['ID'],
    'order' => ['SORT' => 'asc']
]);
while ($ar = $rs->fetch()) {
    $dealer = new Dealer($ar['ID']);
    $direction = [];
    foreach ($dealer->getProperty('direction') as $key => $value){
        $direction[$key] = htmlspecialchars($value);
    }
    $item = [
        'name' => $dealer->getField('NAME'),

        'country' => $dealer->getProperty('country'),
        'city' => $dealer->getProperty('city'),
        'street' => $dealer->getProperty('street'),
        'address' => $dealer->getProperty('address'),

        'description' => implode('.  ', $direction),
        'description_array' => $direction,

        'url' => implode(', ', $dealer->getProperty('site')),
        'url_array' => $dealer->getProperty('site'),

        'phones' => implode(', ', $dealer->getProperty('phone')),
        'phones_array' => $dealer->getProperty('phone'),

        'latlng' => $dealer->getProperty('coordinates'),
    ];
    $result['items'][] = $item;
}

//in this case can be reworked
echo json_encode($result, JSON_UNESCAPED_UNICODE);

