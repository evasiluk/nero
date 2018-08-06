<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Где купить");
?>



    <div class="sticky-bounds">
        <?\Astronim\Helper::includeFile('template/header/header', ['show_border' => false]);?>
        <?\Astronim\Helper::includeFile('template/header/content-title-block', ['show_border' => false]);?>
    </div>
    <div class="app-dealer js-app-dealers" data-file="/dealers.csv">

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

                            <div class="filter-node filter-node-optional">
                                <label class="filter-label">Направление:</label>
                                <div class="filter-ctrl">
                                    <select data-directions></select>
                                </div>
                            </div>

                            <div class="filter-node filter-node-optional">
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
                                Магазинов найдено:&nbsp;<b class="js-stores-count">0</b>
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
                                <a href="registration/" class="button button--bgred button--arrow"><span>Стать дилером</span></a>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <script id="tmpl-place" type="text/x-jquery-tmpl">
                <div class="place">
                    <div class="col">
                        <h4>${name}</h4>
                        <p>${address}</p>
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
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>