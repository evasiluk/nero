<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

?>

<!--search shutter-->
<div class="shutter search-shutter shutter--wide search-shutter-js">
    <div class="shutter__align ">
        <div class="shutter__holder">
            <div class="search-form">
                <form action="#" method="post" class="js-search-form">
                    <div class="search-form__field input-wrap">
                        <input type="search" placeholder="текст для поиска"
                               class="search-form__input js-search-form__input field-effects-js" value="<?=$arResult["query"]?>" name="<?=$arResult['param_name_query']?>"/>
                        <div class="search-form__btn">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 89.8 89.8" width="24"
                                 height="24">
                                <path d="M68.1 61c11.4-14.9 10.3-36.3-3.3-49.9C57.6 3.9 48.1 0 37.9 0c-10.1 0-19.7 3.9-26.8 11.1C3.9 18.3 0 27.8 0 37.9c0 10.1 3.9 19.7 11.1 26.8 7.2 7.2 16.7 11.1 26.8 11.1 8.4 0 16.5-2.8 23.1-7.8l21.8 21.7 7.1-7.1L68.1 61zM57.7 57.7c-5.3 5.3-12.3 8.2-19.8 8.2 -7.5 0-14.5-2.9-19.8-8.2C12.9 52.4 10 45.4 10 37.9c0-7.5 2.9-14.5 8.2-19.8C23.5 12.9 30.5 10 37.9 10c7.5 0 14.5 2.9 19.8 8.2C68.6 29.1 68.6 46.8 57.7 57.7z"></path>
                            </svg>
                            <span>Искать</span>
                            <input type="submit" name="search" value="">
                        </div>
                    </div>
                </form>
            </div>
            <?if($arResult['total_count']){?>
                <div class="search-counter">найдено совпадений: <span class="mark js-search-results__count"><?=$arResult['total_count']?></span></div>
            <?}?>
            <div class="search-results">
                <div class="search-results__list js-search-results__list">
                    <? foreach ($arResult['items']['iblock'] as $item) {
                        $no_image = empty($item['PREVIEW_PICTURE']);?>
                        <div class="search-results__item<?=($no_image ? ' no-image': '')?>">
                            <a href="<?=$item['URL']?>" class="search-results__inner">
                                <div class="search-results__img">
                                    <?if(!$no_image){?>
                                    <img src="<?=$item['PREVIEW_PICTURE']['SRC']?>" alt="<?=$item['PREVIEW_PICTURE']['ALT']?>"/>
                                    <?}?>
                                </div>
                                <div class="search-results__title"><?=$item['TITLE_FORMATED']?></div>
                                <div class="search-results__text"><?=$item['BODY_FORMATED']?></div>
                            </a>
                        </div>
                    <?}?>
                    <? foreach ($arResult['items']['static'] as $item) {
                        $no_image = empty($item['PREVIEW_PICTURE']);?>
                        <div class="search-results__item<?=($no_image ? ' no-image': '')?>">
                            <a href="<?=$item['URL']?>" class="search-results__inner">
                                <div class="search-results__img">
                                    <?if(!$no_image){?>
                                    <img src="<?=$item['PREVIEW_PICTURE']['SRC']?>" alt="<?=$item['PREVIEW_PICTURE']['ALT']?>"/>
                                    <?}?>
                                </div>
                                <div class="search-results__title"><?=$item['TITLE_FORMATED']?></div>
                                <div class="search-results__text"><?=$item['BODY_FORMATED']?></div>
                            </a>
                        </div>
                    <?}?>
                    <? foreach ($arResult['items']['catalog'] as $item) {
                        $no_image = empty($item['PREVIEW_PICTURE']);?>
                        <div class="search-results__item<?=($no_image ? ' no-image': '')?>">
                            <a href="<?=$item['URL']?>" class="search-results__inner">
                                <div class="search-results__img">
                                    <?if(!$no_image){?>
                                    <img src="<?=$item['PREVIEW_PICTURE']['SRC']?>" alt="<?=$item['PREVIEW_PICTURE']['ALT']?>"/>
                                    <?}?>
                                </div>
                                <div class="search-results__title"><?=$item['TITLE_FORMATED']?></div>
                                <div class="search-results__text"><?=$item['BODY_FORMATED']?></div>
                            </a>
                        </div>
                    <?}?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--search shutter end-->
