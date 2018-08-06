<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$this->setFrameMode(true);

$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/colors.css',
	'TEMPLATE_CLASS' => 'bx-'.$arParams['TEMPLATE_THEME']
);

if (isset($templateData['TEMPLATE_THEME']))
{
	$this->addExternalCss($templateData['TEMPLATE_THEME']);
}
?>
<?
$iblock_id = $arParams["IBLOCK_ID"];
//print_pre($arResult["ITEMS"]);

$types_group_id = 0;
$lines_group_id = 0;

foreach($arResult["ITEMS"] as $id=>$ar) {
    if($ar["CODE"] == "type") {
        $types_group_id = $id;
    }
    if($ar["CODE"] == "line") {
        $lines_group_id = $id;
    }
}

if($types_group_id) {
    $types = array();
    foreach($arResult["ITEMS"][$types_group_id]["VALUES"] as $id =>$type) {
        $types[] = $id;
    }

    $props = get_iblock_properties($iblock_id);
    $linked_props = array();

    foreach($types as $id) {
        foreach($props as $key => $prop_id) {
            if(strpos($key, "T".$id) === 0) {
                $linked_props[$id][] = $prop_id;
            }
        }
    }


}


?>

<form class="filter js-filter bg--white" id="nero-cat-filter">
    <input type="hidden" id="sort_name" name="sort" value="<?=$_REQUEST["sort"]?>">
    <input type="hidden" id="sort_order" name="order" value="<?=$_REQUEST["order"]?>">
    <div class="filter-row" id="config-head">

        <div class="filter-wrap">

            <div class="filter-layout">

                <div class="filter-aside">

                    <div class="filter-node">
                        <a href="#" class="button button--red button-filter js-filter-toggle" disabled="disabled">
                            <svg viewBox="0 0 200 200"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#ico-filter"></use></svg>
                            <span><?=GetMessage("ALL_FILTERS")?></span>
                        </a>
                        <a href="#" class="button button--red button-filter button-filter-close js-filter-toggle">
                            <svg viewBox="0 0 32 32"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#ico-close"></use></svg>
                            <span><?=GetMessage("HIDE_FILTERS")?></span>
                        </a>
                    </div>

                </div>

                <div class="filter-selects">
                    <?if(SITE_ID == "s2"){
                        $data = get_hl_data(2);
                        $translated = array();
                        foreach($data as $ar) {
                            $translated[$ar["UF_RU"]] = $ar["UF_EN"];
                        }
                    }
                    ?>
                    <?if($arResult["ITEMS"][$types_group_id]["VALUES"]):?>
                        <div class="filter-node xxxfilter-select">
                            <label class="filter-label"><?=GetMessage("DEVICE_TYPE")?></label>
                            <div class="filter-ctrl">
                                <select data-select-type name="arrFilter_<?=$types_group_id?>">
                                    <option value="all"><?=GetMessage("ALL")?></option>
                                    <?//77 - код свойства
                                    // заменил на переменную - из-за нескольких каталогов
                                    ?>

                                    <?foreach($arResult["ITEMS"][$types_group_id]["VALUES"] as $type):?>
                                        <option <?if($_GET[$type["CONTROL_NAME"]] == "Y"):?>selected<?endif?> value="<?=$type["CONTROL_NAME"]?>">
                                            <?if(SITE_ID == "s2"):?>
                                                <?= $translated[$type["VALUE"]] ?>
                                            <?else:?>
                                                <?=$type["VALUE"]?>
                                            <?endif?>

                                        </option>
                                    <?endforeach?>
                                </select>
                            </div>
                        </div>
                    <?endif?>

                    <?if($arResult["ITEMS"][$lines_group_id]["VALUES"]):?>
                        <div class="filter-node">
                            <label class="filter-label"><?=GetMessage("LINE")?></label>
                            <div class="filter-ctrl">
                                <select data-select-line>
                                    <option value="all"><?=GetMessage("ALL")?></option>
                                    <?//78 - код свойства?>
                                    <?foreach($arResult["ITEMS"][$lines_group_id]["VALUES"] as $type):?>
                                        <option <?if($_GET[$type["CONTROL_NAME"]] == "Y"):?>selected<?endif?> value="<?=$type["CONTROL_NAME"]?>"><?=$type["VALUE"]?></option>
                                    <?endforeach?>
                                </select>
                            </div>
                        </div>
                    <?endif?>
                </div>

                <div class="filter-aside align-right">
                    <div class="filter-node">
                        <div class="filter-sort">
                            <a href="#" class="link--arrow-down">
                                <span><?=GetMessage("SORT")?></span>
                            </a>
                            <div class="submenu">

                                <div class="submenu-in">
                                    <p><a data-sort="date" data-order="desc" href=""><?=GetMessage("DATE")?></a></p>
                                    <p><a data-sort="name" data-order="asc" href=""><?=GetMessage("NAME")?></a></p>
                                    <p><a data-sort="price" data-order="asc" href=""><?=GetMessage("PRICE_UP")?></a></p>
                                    <p><a data-sort="price" data-order="desc" href=""><?=GetMessage("PRICE_DW")?></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="filter-full js-filter-full">
        <div class="filter-row filter-full-in" id="config-main">
            <div class="filter-wrap">
<!--                новый фильтр-->
                <?if(SITE_ID == "s2"){
                    $data = get_hl_data(3);
                    $translated_filter = array();
                    foreach($data as $ar) {
                        $translated_filter[$ar["UF_RU"]] = $ar["UF_EN"];
                    }

                    $data = get_hl_data(4);
                    $translated_filter_values = array();
                    foreach($data as $ar) {
                        $translated_filter_values[$ar["UF_RU"]] = $ar["UF_EN"];
                    }
                }
                ?>
                <?if($types):?>

                    <?foreach($types as $type):?>
                        <div class="flex-row js-filter-view-type" data-for="<?=$arResult["ITEMS"][$types_group_id]["VALUES"][$type]["CONTROL_NAME"]?>" <?if($_GET[$arResult["ITEMS"][$types_group_id]["VALUES"][$type]["CONTROL_NAME"]] != "Y"):?>style="display: none"<?endif?>>
                            <!-- <p><strong>Выбираем <?=$arResult["ITEMS"][$types_group_id]["VALUES"][$type]["VALUE"]?></strong></p> -->
                            <?foreach($arResult["ITEMS"] as $id=>$item):?>
                                <?if(in_array($item["CODE"], array("type", "line"))) continue;?>
                                <?if(!$item["VALUES"]) continue;?>
                                <?if(!in_array($id, $linked_props[$type])) continue;?>
                                <div class="col-xs-6 col-sm-4 col-md-3">
                                    <div class="filter-group">
                                        <div class="filter-group-title">
                                            <?if(SITE_ID == "s2"):?>
                                                <?=$translated_filter[$item["NAME"]] ?>
                                            <?else:?>
                                                <?=$item["NAME"]?>
                                            <?endif?>
                                        </div>
                                        <?if($item["DISPLAY_TYPE"] == "F"):?>
                                            <ul>
                                                <?foreach($item["VALUES"] as $value):?>
                                                    <li>
                                                        <label>
                                                            <input type="checkbox" name="<?=$value["ID"]?>" value="<?=$value["CONTROL_ID"]?>" id="">
                                                            <span>
                                                                <?if(SITE_ID == "s2" && !is_numeric($value["VALUE"])):?>
                                                                    <?=$translated_filter_values[$value["VALUE"]] ?>
                                                                <?else:?>
                                                                    <?=$value["VALUE"]?>
                                                                <?endif?>
                                                            </span>
                                                        </label>
                                                    </li>
                                                <?endforeach?>
                                            </ul>
                                        <?endif?>
                                        <?if($item["DISPLAY_TYPE"] == "P"):?>
                                            <div class="filter-ctrl">
                                                <select data-filter-full-select name="arrFilter_<?=$item["ID"]?>">
                                                    <option value="all">Все</option>
                                                    <?foreach($item["VALUES"] as $value):?>
                                                        <option value="<?=$value["CONTROL_NAME"]?>">
                                                            <?if(SITE_ID == "s2" && !is_numeric($value["VALUE"])):?>
                                                                <?=$translated_filter_values[$value["VALUE"]] ?>
                                                            <?else:?>
                                                                <?=$value["VALUE"]?>
                                                            <?endif?>
                                                        </option>
                                                    <?endforeach?>
                                                </select>
                                            </div>
                                        <?endif?>
                                    </div>
                                </div>
                            <?endforeach?>
                        </div>
                    <?endforeach?>
                <?else:?>
                                    <div class="flex-row" id="without_types_filter">
                                        <?foreach($arResult["ITEMS"] as $item):?>
                                            <?if(in_array($item["CODE"], array("type", "line"))) continue;?>
                                            <?if(!$item["VALUES"]) continue;?>
                                            <div class="col-xs-6 col-sm-4 col-md-3">
                                                <div class="filter-group">
                                                    <div class="filter-group-title">
                                                        <?if(SITE_ID == "s2"):?>
                                                            <?=$translated_filter[$item["NAME"]] ?>
                                                        <?else:?>
                                                            <?=$item["NAME"]?>
                                                        <?endif?>
                                                    <?if($item["DISPLAY_TYPE"] == "F"):?>
                                                        <ul>
                                                            <?foreach($item["VALUES"] as $value):?>
                                                                <li>
                                                                    <label>
                                                                        <input type="checkbox" name="<?=$value["ID"]?>" value="<?=$value["CONTROL_ID"]?>" id="">
                                                                        <span>
                                                                            <?if(SITE_ID == "s2" && !is_numeric($value["VALUE"])):?>
                                                                                <?=$translated_filter_values[$value["VALUE"]] ?>
                                                                            <?else:?>
                                                                                <?=$value["VALUE"]?>
                                                                            <?endif?>
                                                                        </span>
                                                                    </label>
                                                                </li>
                                                            <?endforeach?>
                                                        </ul>
                                                    <?endif?>
                                                    <?if($item["DISPLAY_TYPE"] == "P"):?>
                                                        <div class="filter-ctrl">
                                                            <select data-filter-full-select name="arrFilter_<?=$item["ID"]?>">
                                                                <option value="all">Все</option>
                                                                <?foreach($item["VALUES"] as $value):?>
                                                                    <option value="<?=$value["CONTROL_NAME"]?>">
                                                                        <?if(SITE_ID == "s2" && !is_numeric($value["VALUE"])):?>
                                                                            <?=$translated_filter_values[$value["VALUE"]] ?>
                                                                        <?else:?>
                                                                            <?=$value["VALUE"]?>
                                                                        <?endif?>
                                                                    </option>
                                                                <?endforeach?>
                                                            </select>
                                                        </div>
                                                    <?endif?>
                                                </div>
                                            </div>
                                        <?endforeach?>
                                    </div>
                <?endif?>

<!--                новый фильтр конец-->



<!--                <div class="flex-row">-->
<!--                    --><?//foreach($arResult["ITEMS"] as $item):?>
<!--                        --><?//if(in_array($item["CODE"], array("type", "line"))) continue;?>
<!--                        --><?//if(!$item["VALUES"]) continue;?>
<!--                        <div class="col-xs-6 col-sm-4 col-md-3">-->
<!--                            <div class="filter-group">-->
<!--                                <div class="filter-group-title">--><?//=$item["NAME"]?><!--</div>-->
<!--                                --><?//if($item["DISPLAY_TYPE"] == "F"):?>
<!--                                    <ul>-->
<!--                                        --><?//foreach($item["VALUES"] as $value):?>
<!--                                            <li>-->
<!--                                                <label>-->
<!--                                                    <input type="checkbox" name="--><?//=$value["ID"]?><!--" value="--><?//=$value["CONTROL_ID"]?><!--" id="">-->
<!--                                                    <span>--><?//=$value["VALUE"]?><!--</span>-->
<!--                                                </label>-->
<!--                                            </li>-->
<!--                                        --><?//endforeach?>
<!--                                    </ul>-->
<!--                                --><?//endif?>
<!--                                --><?//if($item["DISPLAY_TYPE"] == "P"):?>
<!--                                    <div class="filter-ctrl">-->
<!--                                        <select data-filter-full-select name="arrFilter_--><?//=$item["ID"]?><!--">-->
<!--                                            <option value="all">Все</option>-->
<!--                                            --><?//foreach($item["VALUES"] as $value):?>
<!--                                                <option value="--><?//=$value["CONTROL_NAME"]?><!--">--><?//=$value["VALUE"]?><!--</option>-->
<!--                                            --><?//endforeach?>
<!--                                        </select>-->
<!--                                    </div>-->
<!--                                --><?//endif?>
<!--                            </div>-->
<!--                        </div>-->
<!--                    --><?//endforeach?>
<!--                </div>-->
            </div>
        </div>
        <div class="filter-row filter-full-footer" id="config-foot">
            <a href="#" class="ico-link link--red filter-reset js-filter-reset">
                <svg viewBox="0 0 200 200"><use xlink:href="#ico-reset"></use></svg>
                <span><?=GetMessage("CLEAR_FILTER")?></span>
            </a>
        </div>
    </div>
</form>


