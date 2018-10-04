<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arParams */
/** @var array $arResult */
/** @var CBitrixComponentTemplate $this */

/** @var PageNavigationComponent $component */
$component = $this->getComponent();

$this->setFrameMode(true);

$colorSchemes = array(
	"green" => "bx-green",
	"yellow" => "bx-yellow",
	"red" => "bx-red",
	"blue" => "bx-blue",
);
if(isset($colorSchemes[$arParams["TEMPLATE_THEME"]]))
{
	$colorScheme = $colorSchemes[$arParams["TEMPLATE_THEME"]];
}
else
{
	$colorScheme = "";
}
?>






<div class="pagination">
    <div class="pagination-row">
        <?if($arResult["CURRENT_PAGE"] > 1):?>
            <div class="pagination-nav">
                <a href="<?=htmlspecialcharsbx($component->replaceUrlTemplate($arResult["CURRENT_PAGE"]-1))?>" class="c-ico ico-50 ico--red">
                    <svg viewBox="0 0 50 50">
                        <use xlink:href="#ico-left"></use>
                    </svg>
                </a>
            </div>

        <?endif?>

        <div class="pagination-list">
            <?if($arResult["CURRENT_PAGE"] > 1):?>
                <a href="<?=htmlspecialcharsbx($arResult["URL"])?>">1</a>
            <?else:?>
                <a href="#" class="active">1</a>
            <?endif?>
            <?if($arResult["CURRENT_PAGE"] > 3):?>
                <span>…</span>
            <?endif?>

            <?
            $page = $arResult["START_PAGE"] + 1;
            while($page <= $arResult["END_PAGE"]-1):
                ?>
                <?if ($page == $arResult["CURRENT_PAGE"]):?>
                <a href="#" class="active"><?=$page?></a>

            <?else:?>
                <a href="<?=htmlspecialcharsbx($component->replaceUrlTemplate($page))?>"><?=$page?></a>
            <?endif?>
                <?$page++?>
            <?endwhile?>
            <?if($arResult["CURRENT_PAGE"] < ($arResult["PAGE_COUNT"] - 2) && $arResult["PAGE_COUNT"] != 4):?>
                <span>…</span>
            <?endif?>
            <?if($arResult["CURRENT_PAGE"] < $arResult["PAGE_COUNT"]):?>
                <?if($arResult["PAGE_COUNT"] > 1):?>
                    <a href="<?=htmlspecialcharsbx($component->replaceUrlTemplate($arResult["PAGE_COUNT"]))?>"><?=$arResult["PAGE_COUNT"]?></a>
                <?endif?>
            <?else:?>
                <a class="active" href="<?=htmlspecialcharsbx($component->replaceUrlTemplate($arResult["PAGE_COUNT"]))?>"><?=$arResult["PAGE_COUNT"]?></a>
            <?endif?>

        </div>
        <?if($arResult["CURRENT_PAGE"] < $arResult["PAGE_COUNT"]):?>
            <div class="pagination-nav">
                <a href="<?=htmlspecialcharsbx($component->replaceUrlTemplate($arResult["CURRENT_PAGE"]+1))?>" class="c-ico ico-50 ico--red">
                    <svg viewBox="0 0 50 50">
                        <use xlink:href="#ico-right"></use>
                    </svg>
                </a>
            </div>
        <?endif?>
    </div>
</div>

