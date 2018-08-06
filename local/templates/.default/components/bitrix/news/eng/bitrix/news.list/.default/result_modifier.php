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
$request = \Bitrix\Main\Context::getCurrent()->getRequest();
foreach ($arResult['ITEMS'] as &$arItem){
    if($link = $arItem['PROPERTIES']['link']['VALUE']){
        $arItem['DETAIL_PAGE_URL'] = $link;
        $arItem['link_attributes'] = 'target="_blank"';
    }

    $url = new \Bitrix\Main\Web\Uri($arItem['DETAIL_PAGE_URL']);
    $url->addParams(['backurl' => $request->getRequestUri()]);
    $arItem['DETAIL_PAGE_URL'] = $url->getUri();

    if($arItem['PREVIEW_PICTURE']['ID'] > 0)
        $arItem['PREVIEW_PICTURE']['SRC'] = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], ['width' => 480, 'height' => 480], BX_RESIZE_IMAGE_EXACT)['src'];
}