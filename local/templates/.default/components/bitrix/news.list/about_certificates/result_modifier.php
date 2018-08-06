<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
$request = Bitrix\Main\Context::getCurrent()->getRequest();
foreach ($arResult['ITEMS'] as $arItem) {
    $arResult['SECTIONS'][$arItem['IBLOCK_SECTION_ID']] = $arItem['IBLOCK_SECTION_ID'];
}

$rs = CIBlockSection::getList([
    'SORT' => 'ASC',
    'NAME' => 'DESC'
], [
    'IBLOCK_ID' => $arParams['IBLOCK_ID'],
//        'ID' => $arResult['SECTIONS']
], true, [
        'ID',
        'IBLOCK_ID',
        'NAME',
        'CODE'
    ]
);

$arResult['SECTIONS'] = [];
while ($ar = $rs->GetNext()) {
    $arResult['SECTIONS'][] = $ar;
}

foreach ($arResult['ITEMS'] as $arItem) {
    $arItem['PROPERTIES']['file'] = CFile::GetFileArray($arItem['PROPERTIES']['file']['VALUE']);
    foreach($arResult['SECTIONS'] as $key => $item){
        if($item['ID'] == $arItem['IBLOCK_SECTION_ID']){
            $arResult['SECTIONS'][$key]['ITEMS'][] = $arItem;
        }
    }
}
