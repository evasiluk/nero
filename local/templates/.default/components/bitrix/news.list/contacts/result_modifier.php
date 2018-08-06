<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
foreach (\Astronim\Region\RegionController::getInstance()->getRegions() as $region) {
    $arResult['ITEMS_BY_REGION'][$region->getId()] = [
        'REGION' => $region,
        'ITEMS' => [],
        'SELECTED' => ($region->getId() == $arParams['REGION']),
        'LINK' => \Astronim\Region\RegionController::getInstance()->getSwitchRegionUri($region)->getUri()
    ];
}

foreach ($arResult['ITEMS'] as $key => $arItem) {
    $region_id = $arItem['PROPERTIES']['region']['VALUE'];
    $is_main = $arItem['PROPERTIES']['main']['VALUE_XML_ID'] == 'Y';

    if ($is_main && ($region_id == $arParams['REGION'])) {
        $arItem['REGION'] = \Astronim\Region\RegionController::getInstance()->getRegionByCode($arItem['CODE']);
        $arResult['MAIN'] = $arItem;
        unset($arResult['ITEMS'][$key]);
        continue;
    }

    $arResult['ITEMS_BY_REGION'][$region_id]['ITEMS'][] = $arItem;
}

$re= usort($arResult['ITEMS_BY_REGION'], function ($a, $b){
    $id = \Astronim\Region\RegionController::getInstance()->getCurrentRegion()->getId();

    $id = 0;
    switch($_SERVER["HTTP_HOST"]) {
        case "nero.test.astronim.com": $id = 390;
            break;
        case "nero-ua.test.astronim.com" : $id = 398;
            break;
        case "nero-spb.test.astronim.com" : $id = 392;
            break;
        case "nero-msk.test.astronim.com" : $id = 391;
            break;
        default: $id = 390;
        break;
    }

    if($a['REGION']->getId() == $id) return -1;
    if($b['REGION']->getId() == $id) return 1;

    if ($a['REGION']->getField('SORT') == $b['REGION']->getField('SORT')) {
        return 0;
    }

    return ($a['REGION']->getField('SORT') < $b['REGION']->getField('SORT')) ? -1 : 1;
});

