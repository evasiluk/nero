<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
?>
<? foreach ($arResult['SECTIONS'] as $id => $section) { ?>
    <div class="contacts-box">
        <div class="contacts-box__title"><?= (trim($section['NAME']) ? "{$section['NAME']}: " : ''); ?></div>
        <? foreach ($section['ITEMS'] as $item) { ?>
            <div class="contacts-box__item">
                <div class="contacts-box__label"><?= $item['NAME'] ?></div>
                <div class="contacts-box__content">
                    <? foreach ($item['PROPERTIES'] as $property) {
                        if(!$property['VALUE']) continue;?>
                        <div class="contacts-box__dt"><?= $property['NAME'] ?>:</div>

                        <?if(!is_array($property['VALUE'])) $property['VALUE'] = [$property['VALUE']];
                        foreach ($property['VALUE'] as $value){
                            if(strpos($property['CODE'], 'phone') !== false){
                                $value = "<a href='tel:{$value}'>{$value}</a>";
                            }
                            if(strpos($property['CODE'], 'email') !== false){
                                $value = "<a href='mailto:{$value}'>{$value}</a>";
                            }?>
                            <div class="contacts-box__dd"><?= $value ?></div>
                        <? }?>
                    <? } ?>
                </div>
            </div>
        <? } ?>
    </div>
<? } ?>
