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

use Bitrix\Iblock\ElementTable,
    Bitrix\Main\Context;

$request = Context::getCurrent()->getRequest();
$cache = Bitrix\Main\Data\Cache::createInstance();
$uri = new \Bitrix\Main\Web\Uri($request->getRequestUri());

/** collect years */
$cache_id = 'years' . $arParams['IBLOCK_ID'] . serialize($arResult['VARIABLES']) . '';
if ($cache->initCache($arParams['CACHE_TIME'], $cache_id, '/iblock/')) {
    $arResult['years'] = $cache->getVars();
} elseif ($cache->startDataCache()) {
    $filter = [
        'IBLOCK_ID' => $arParams['IBLOCK_ID']
    ];
    $arResult['years'] = ElementTable::getList([
        'select' => [
            'CNT', 'YEAR'
        ],
        'filter' => $filter,
        'runtime' => array(
            new \Bitrix\Main\Entity\ExpressionField('YEAR', 'YEAR(ACTIVE_FROM)'),
            new \Bitrix\Main\Entity\ExpressionField('CNT', 'COUNT(*)')
        ),
        'order' => ['YEAR' => 'asc'],
        'group' => ['YEAR']
    ])->fetchAll();
    $cache->endDataCache($arResult['years']);
}
usort($arResult['years'], function ($a, $b) {
    return ($a['YEAR'] == $b['YEAR'] ? 0 : ($a['YEAR'] > $b['YEAR'] ? -1 : 1));
});

$year = (int) $request->get('year');
$key = array_search($year, array_column($arResult['years'], 'YEAR'));
if ($key !== false)
    $arResult['years'][$key]['selected'] = true;
/** \collect years end */

/** collect sections */
$cache_id = 'sections' . $arParams['IBLOCK_ID'] . serialize($arResult['VARIABLES']) . '';
if ($cache->initCache($arParams['CACHE_TIME'], $cache_id, '/iblock/')) {
    $arResult['sections'] = $cache->getVars();
} elseif ($cache->startDataCache()) {
    $filter = [
        'IBLOCK_ID' => $arParams['IBLOCK_ID']
    ];
    $arResult['sections'] = \Bitrix\Iblock\SectionTable::getList([
        'order' => ['SORT' => 'asc'],
        'select' => [
            'ID', 'NAME'
        ],
        'filter' => $filter
    ])->fetchAll();
    $cache->endDataCache($arResult['sections']);
}
$sid = (int) $request->get('sid');
$key = array_search($sid, array_column($arResult['sections'], 'ID'));
if ($key !== false)
    $arResult['sections'][$key]['selected'] = true;
/** \collect sections end */


if (!$arParams['FILTER_NAME']) $arParams['FILTER_NAME'] = uniqid('newsfilter_');
if($year){
    $date = new \Bitrix\Main\Type\DateTime($year . '-01-01', 'Y-m-d');
    $GLOBALS[$arParams['FILTER_NAME']]['>=DATE_ACTIVE_FROM'] = ConvertTimeStamp($date->getTimestamp(), 'FULL');
    $GLOBALS[$arParams['FILTER_NAME']]['<DATE_ACTIVE_FROM'] = ConvertTimeStamp($date->add('1 year')->getTimestamp(), 'FULL');
}
if($sid){
    $date = new \Bitrix\Main\Type\DateTime($year . '-01-01', 'Y-m-d');
    $GLOBALS[$arParams['FILTER_NAME']]['IBLOCK_SECTION_ID'] = $sid;
    $GLOBALS[$arParams['FILTER_NAME']]['INCLUDE_SUBSECTIONS'] = 'Y';
}
?>


<form class="filter js-news-filter">

    <div class="filter-row">

        <div class="filter-wrap">

            <div class="filter-selects">

                <div class="filter-node">
                    <label class="filter-label">Год публикации:</label>
                    <div class="filter-ctrl">
                        <select name="year" data-select>
                            <option value="0">Все</option>
                            <? foreach ($arResult['years'] as $item) {?>
                                <option<? if ($item['selected']) { ?> selected<? } ?>
                                        value="<?= $item['YEAR'] ?>"
                                >
                                    <?= $item['YEAR'] ?>
                                </option>
                            <? } ?>
                        </select>
                    </div>
                </div>

                <div class="filter-node">
                    <label class="filter-label">Рубрика:</label>
                    <div class="filter-ctrl">
                        <select name="sid" data-select>
                            <option value="0">Все</option>
                            <? foreach ($arResult['sections'] as $item) {?>
                                <option<? if ($item['selected']) { ?> selected<? } ?>
                                        value="<?= $item['ID'] ?>"
                                >
                                    <?= $item['NAME'] ?>
                                </option>
                            <? } ?>
                        </select>
                    </div>
                </div>

            </div>

        </div>

    </div>
</form>