<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
\Bitrix\Main\Loader::includeModule('iblock');
?>

<div class="catalog-entry-list usercontent wrap">

    <? foreach ($arResult['SECTIONS'] as $arSection) {

        $filter = getFilterProperties($arParams['IBLOCK_ID'], $arSection['ID']);
        //print_pre($filter);
        $uri = new \Bitrix\Main\Web\Uri($arSection['SECTION_PAGE_URL']);
        $uri->addParams(['set_filter' => 'Y']);?>
        <section class="catalog-section">
            <img src="<?= $arSection['PICTURE']['SRC'] ?>" alt="<?= $arSection['PICTURE']['ALT'] ?>">
            <div class="flex-row">
                <div class="col-xs">
                    <h2 class="catalog-section-title"><a
                                href="<?= $arSection['SECTION_PAGE_URL'] ?>"><?= $arSection['NAME'] ?></a></h2>
                    <p><?= $arSection['DESCRIPTION'] ?></p>
                </div>

                    <div class="col-xs catalog-section-aside">
                        <?if($filter['line']['VALUES']):?>
                            <?//print_pre($filter)?>
                        <p><?=GetMessage("LINE")?></p>
                        <ul>
                            <?foreach($filter['line']['VALUES'] as $item):?>
                                <li><a href="<?= $arSection['SECTION_PAGE_URL'] ?>?set_filter=Y&<?=$arParams['FILTER_NAME'].$item['CONTROL_NAME']?>=<?=$item['HTML_VALUE']?>"><?= $item['VALUE'] ?></a></li>
                            <?endforeach?>
                        </ul>
                        <?endif?>
                    </div>

            </div>
            <footer class="catalog-section-footer">
                <a href="<?= $arSection['SECTION_PAGE_URL'] ?>" class="button button--bgred button--arrow"><span><?=GetMessage("WATCH_ALL")?></span></a>
            </footer>
        </section>

        <div class="catalog-box-list">
            <div class="flex-row">
                <?if(SITE_ID == "s2"){
                   $data = get_hl_data(2);
                   $translated = array();
                   foreach($data as $ar) {
                       $translated[$ar["UF_RU"]] = $ar["UF_EN"];
                   }
                }

                ?>
                <?$i = 0;?>
                <? foreach ($filter['type']['VALUES'] as $key=>$item) {
                    $i++;
                      //if($i > 3) break;  
//                    $uri = new \Bitrix\Main\Web\Uri($arSection['SECTION_PAGE_URL']);
//                    $uri->addParams(['set_filter' => 'Y']);
//                    foreach ($filter['line']['VALUES'] as $i) {
//                        $uri->addParams(["{$arParams['FILTER_NAME']}{$i['CONTROL_NAME']}" => $i['HTML_VALUE']]);
//                    }
//                    $uri->addParams(["{$arParams['FILTER_NAME']}{$item['CONTROL_NAME']}" => $item['HTML_VALUE']]);?>
                    <div class="col-xs-12 col-sm-6 col-md">
                        <a href="<?= $arSection['SECTION_PAGE_URL'] ?>?set_filter=Y&<?=$arParams['FILTER_NAME'].$item['CONTROL_NAME']?>=<?=$item['HTML_VALUE']?>" class="catalog-box">
                            <div class="catalog-box-icon">
                                <svg>
                                    <use xlink:href="<?= DEFAULT_ASSETS_PATH ?>/i/icons/product-type.svg#<?= $item['URL_ID'] ?>"></use>
                                </svg>
                            </div>
                            <div class="catalog-box-text">
                                <?if(SITE_ID == "s2"):?>
                                    <?= $translated[$item['VALUE']] ?>
                                <?else:?>
                                    <?= $item['VALUE'] ?>
                                <?endif?>

                            </div>
                        </a>
                    </div>

                <? } ?>
            </div>
        </div>
    <? } ?>

</div>