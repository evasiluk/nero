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
$this->setFrameMode(true);
$helper = new \Astronim\FaqVoteAction($arParams['IBLOCK_ID']);
?>

<div class="app-dealer">

    <div class="sticky-bounds">

        <div class="filter">

            <div class="filter-row">

                <div class="filter-wrap align-center">

                    <div class="filter-selects">

                        <div class="filter-node">
                            <label class="filter-label">Страна:</label>
                            <div class="filter-ctrl">
                                <select data-countries></select>
                            </div>
                        </div>

                        <div class="filter-node">
                            <label class="filter-label">Город:</label>
                            <div class="filter-ctrl">
                                <select data-cities></select>
                            </div>
                        </div>

                        <div class="filter-node">
                            <label class="filter-label">Направление:</label>
                            <div class="filter-ctrl">
                                <select data-directions></select>
                            </div>
                        </div>

                        <div class="filter-node">
                            <label class="filter-label">Где купить:</label>
                            <div class="filter-ctrl">
                                <select data-streets></select>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <div class="filter-row">

                <div class="filter-wrap filter-dealers flex-row middle-xs">

                    <div class="col-xs filter-found">
                        <div class="filter-node">
                            Магазинов найдено:&nbsp;<b class="js-stores-count">58</b>
                        </div>
                    </div>

                    <div class="col-xs center-xs filter-view">

                        <div class="b-toggler js-toggler js-dealers-tabs">
                            <div class="toggler-action">
                                <input  id="tab-1" type="radio" name="tab" checked>
                                <label for="tab-1">
                                    <svg class="ico-list" viewBox="0 0 12 12">
                                        <use xlink:href="#ico-list"></use>
                                    </svg>
                                    <span>Списком</span>
                                </label>

                                <input  id="tab-2" type="radio" name="tab">
                                <label for="tab-2">
                                    <svg class="ico-placemark" viewBox="0 0 300 300">
                                        <use xlink:href="#ico-placemark"></use>
                                    </svg>
                                    <span>На карте</span>
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="col-xs end-xs filter-col">
                        <div class="filter-node">
                            <a href="#" class="button button--bgred button--arrow"><span>Стать дилером</span></a>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <script id="tmpl-place" type="text/x-jquery-tmpl">
					<div class="place">
						<div class="col">
							<h4>${name}</h4>
							<p>${adress}</p>
						</div>
						<div class="col">
							<span class="places-phones">${phones}</span>
							<br>
							<a href="http://${url}" target="_blank">${url}</a>
						</div>
						<div class="col">
							<p>${description}</p>
						</div>
						<div class="col">
							<a href="#" class="place-map-label" data-latlng="${latlng}">
								<svg class="ico-placemark" viewBox="0 0 338.7 460.7">
									<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#ico-placemark-outline"></use>
								</svg>
							</a>
						</div>
					</div>
				</script>

        <div class="tab-content" id="tab-1-content">

            <div class="wrap">

                <div class="places" id="places-list">

                    <div class="places-loading"><img src="<?=DEFAULT_ASSETS_PATH?>/i/preloader.svg" alt=""></div>

                </div>

            </div>

        </div>

        <div class="tab-content" id="tab-2-content">

            <div class="dealers-map-wrap">
                <div class="dealers-map" id="dealersMap"></div>
            </div>

        </div>

    </div>

</div>

<? foreach ($arResult["ITEMS"] as $arItem) { ?>
    <div id="question<?=$arItem['ID']?>">
        <a href="#" class="faq-q"><span><?= $arItem['NAME'] ?></span></a>
        <div class="faq-a">
            <p><?= $arItem['PREVIEW_TEXT'] ?></p>
            <div class="faq-footer js-faq__is_usefull" data-id="<?=$arItem['ID']?>">
                <span>Полезный ответ?</span>
                <a href="#" data-id="<?=$arItem['ID']?>"
                   data-action="<?=$helper::ACTION_PLUS?>"
                    <?if($helper->getUserLastVote($arItem['ID']) == $helper::ACTION_PLUS) echo "class='active'";?>
                >
                    Да
                </a>
                <a href="#" data-id="<?=$arItem['ID']?>"
                   data-action="<?=$helper::ACTION_MINUS?>"
                    <?if($helper->getUserLastVote($arItem['ID']) == $helper::ACTION_MINUS) echo "class='active'";?>
                >
                    Нет
                </a>
                <a href="#" class="button js-goto" data-goto="#form_faq" data-shift="false">Задать вопрос</a>
            </div>
        </div>
    </div>
<? } ?>
