<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<script>
    var currentRegion = "<?=$arResult["PHRASE"]?>";
</script>

<?if($arResult):?>
    <div class="region-select js-region-select">
        <div class="rs-section js-region-dialog" style="display: none;">
            <div class="rs-section-close js-region-select-close">
                <svg class="ico-close" viewBox="0 0 32 32">
                    <use xlink:href="#ico-close"></use>
                </svg>
            </div>
            <h4>Ваш регион <span class="js-region-suggest"></span>?</h4>
            <p><a href="http://<?=$arResult["HOST"]?>" class="button button--wide button--bgred js-button-submit">Да, Верно</a></p>
            <p><button class="button button--wide button--red js-button-switch">Выбрать регион</button></p>
        </div>
        <div class="rs-section js-region-list" style="display: none;">
            <div class="rs-section-close js-region-list-close">
                <svg class="ico-close" viewBox="0 0 32 32">
                    <use xlink:href="#ico-close"></use>
                </svg>
            </div>
            <h4>Выбор региона</h4>
            <div class="h-region-in">
                <p><a href="http://<?=BY_HOST?>" class="js-name"><i class="ico-flag"><img src="/local/templates/.default/assets/i/icons/flag-by.png" alt=""></i><span>Беларусь</span></a></p>
                <p><a href="http://<?=UA_HOST?>" class="js-name"><i class="ico-flag"><img src="/local/templates/.default/assets/i/icons/flag-ua.png" alt=""></i><span>Украина</span></a></p>
                <p><a href="http://<?=MSK_HOST?>" class="js-name"><i class="ico-flag"><img src="/local/templates/.default/assets/i/icons/flag-ru.png" alt=""></i><span>Россия (Москва)</span></a></p>
                <p><a href="http://<?=SPB_HOST?>" class="js-name"><i class="ico-flag"><img src="/local/templates/.default/assets/i/icons/flag-ru.png" alt=""></i><span>Россия (Санкт-Петербург)</span></a></p>
            </div>
            <div class="h-region-footer">
                <a href="#" class="button button--bgred button--arrow js-result"><span>Продолжить</span> <span class="hide-480">с новым регионом</span></a>
            </div>
        </div>
    </div>
<?endif?>


