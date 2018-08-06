<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$filters = [
    'country' => [
        'name' => 'Страна'
    ],
    'team' => [
        'name' => 'Команда'
    ]
];
foreach($arResult['ITEMS'] as &$arItem){
    foreach ($filters as $key => &$filter){
        if(($property = $arItem['PROPERTIES'][$key]['VALUE'])){
            $arItem['PROPERTIES'][$key]['value_key'] = md5($property);
            $arItem['filter_data_string'] .= "data-filter-{$key}='{$arItem['PROPERTIES'][$key]['value_key']}'";

            if(!in_array($property, $filter['values'])){
                $filter['values'][$arItem['PROPERTIES'][$key]['value_key']] = $property;
            }
        }
    }
}

$arResult['filters'] = $filters;