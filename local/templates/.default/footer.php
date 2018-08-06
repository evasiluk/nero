<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/**
 * @var $APPLICATION CMain
 * @var $USER CUser
 */
use Astronim\Helper,
    Bitrix\Main\Loader,
    \Bitrix\Main\Localization\Loc;?>


</div>

<div class="sidebar">

    <div class="sidebar-header flex-row middle-xs">
        <div class="col-xs center-xs">
            <a href="#" class="logo">
                <svg class="ico-logo" viewBox="0 0 380.6 76.2">
                    <use xlink:href="#ico-logo"></use>
                </svg>
            </a>
        </div>
    </div>

    <div class="menu-button is-active js-menu-toggle">
        <div class="ico-menu">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </div>
    </div>

    <div class="sidebar-in">

        <?$APPLICATION->IncludeComponent(
            "bitrix:menu",
            "sidebar-in",
            Array(
                "ALLOW_MULTI_SELECT" => "N",
                "CHILD_MENU_TYPE" => "left",
                "DELAY" => "N",
                "MAX_LEVEL" => "2",
                "MENU_CACHE_GET_VARS" => array(""),
                "MENU_CACHE_TIME" => "3600",
                "MENU_CACHE_TYPE" => "N",
                "MENU_CACHE_USE_GROUPS" => "Y",
                "ROOT_MENU_TYPE" => "top",
                "USE_EXT" => "Y"
            )
        );?>

    </div>
</div>

<div class="popup-wrap js-popup">
    <div class="popup-close js-popup-close">
        <svg class="svg" height="48" viewBox="0 0 48 48" width="48" xmlns="http://www.w3.org/2000/svg">
            <path class="path"
                  d="M38 12.83l-2.83-2.83-11.17 11.17-11.17-11.17-2.83 2.83 11.17 11.17-11.17 11.17 2.83 2.83 11.17-11.17 11.17 11.17 2.83-2.83-11.17-11.17z"/>
        </svg>
    </div>
    <div class="popup-table">
        <div class="popup-cell">
            <div class="popup box-shadow">
                <div class="popup-content js-popup-content">
                    <!-- content inserts here -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- телефоны -->
<script id="tmpl-video" type="text/x-jquery-tmpl">
</script>

<noindex>
    <div id="browserUnsupportedPlaceholder" style="display: none">
        <div class="ui-browser-warning ui-browser-warning_old ui-browser-warning_visible">
            <div class="ui-browser-warning__wrapper">
                <div class="ui-browser-warning__container">
                    <div class="ui-browser-warning__title">Ваш браузер безнадежно устарел</div>
                    <p class="ui-browser-warning__description">Наш сайт создан с применением современных технологий для
                        того чтобы сделать его быстрым и удобным.<br>
                        Пожалуйсте, обновите свой браузер.</p>
                    <div class="ui-browser-warning__content ui-browser-warning__content_browsers">
                        <a class="ui-browser-warning__browser" href="https://www.google.ru/chrome/browser/"
                           target="_blank" rel="noopener noreferrer nofollow">
                            <span class="ui-browser-warning__browser-title">Chrome</span>
                            <span class="ui-browser-warning__browser-subtitle">Версия&nbsp;28+</span>
                            <span class="ui-browser-warning__browser-icon ui-browser-warning__browser-icon_chrome">
						</span></a>
                        <a class="ui-browser-warning__browser" href="http://www.opera.com/" target="_blank"
                           rel="noopener noreferrer nofollow">
                            <span class="ui-browser-warning__browser-title">Opera</span>
                            <span class="ui-browser-warning__browser-subtitle">Версия&nbsp;32+</span>
                            <span class="ui-browser-warning__browser-icon ui-browser-warning__browser-icon_opera">
						</span></a>
                        <a class="ui-browser-warning__browser" href="https://www.mozilla.org/ru/firefox/products/"
                           target="_blank" rel="noopener noreferrer nofollow">
                            <span class="ui-browser-warning__browser-title">Firefox</span>
                            <span class="ui-browser-warning__browser-subtitle">Версия&nbsp;28+</span>
                            <span class="ui-browser-warning__browser-icon ui-browser-warning__browser-icon_ff">
						</span></a>
                        <a class="ui-browser-warning__browser" href="https://browser.yandex.ru/" target="_blank"
                           rel="noopener noreferrer nofollow">
                            <span class="ui-browser-warning__browser-title">Яндекс</span>
                            <span class="ui-browser-warning__browser-subtitle">Версия&nbsp;12+</span>
                            <span class="ui-browser-warning__browser-icon ui-browser-warning__browser-icon_ya">
						</span></a>
                        <a class="ui-browser-warning__browser" href="http://www.apple.com/ru/safari/" target="_blank"
                           rel="noopener noreferrer nofollow">
                            <span class="ui-browser-warning__browser-title">Safari</span>
                            <span class="ui-browser-warning__browser-subtitle">Версия&nbsp;6+</span>
                            <span class="ui-browser-warning__browser-icon ui-browser-warning__browser-icon_safari">
						</span></a>
                        <a class="ui-browser-warning__browser"
                           href="https://www.microsoft.com/ru-ru/download/internet-explorer.aspx" target="_blank"
                           rel="noopener noreferrer nofollow">
                            <span class="ui-browser-warning__browser-title">Internet Explorer</span>
                            <span class="ui-browser-warning__browser-subtitle">Версия&nbsp;11+</span>
                            <span class="ui-browser-warning__browser-icon ui-browser-warning__browser-icon_ie">
						</span></a>
                    </div>
                    <div class="ui-browser-warning__content-footer">
                        <span class="ui-browser-warning__link" onclick="$('#browserUnsupportedPlaceholder').remove()">Продолжить с текущей версией браузера</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <noscript id='nojs'>
        <div id="js-browser-warning" class="ui-browser-warning">
            <div class="ui-browser-warning__wrapper">
                <div class="ui-browser-warning__container">
                    <div class="ui-browser-warning__title">
                        JavaScript отключен в&nbsp;вашем браузере
                    </div>
                    <p class="ui-browser-warning__description">
                        Для корректной работы сервисов банка необходимо включить поддержку JavaScript.<br>Выберите
                        браузер
                    </p>
                    <div class="ui-browser-warning__content">
                        <div class="ui-browser-warning__content-wrapper">
                            <label>
                                <input type="radio" name="browser"
                                       class="ui-browser-warning__info-checker ui-browser-warning__info-checker_chrome"
                                       value="Chrome" checked="">
                                <div class="ui-browser-warning__info-checker-icon ui-browser-warning__info-checker-icon_chrome"
                                     data-name="Chrome"></div>
                                <div class="ui-browser-warning__info ui-browser-warning__info_chrome">
                                    <div class="ui-browser-warning__info-text ui-browser-warning__info-text_chrome">
                                        <div class="ui-browser-warning__info-text-title">Для браузера Google Chrome:
                                        </div>
                                        <p class="ui-browser-warning__info-text-description ui-browser-warning__info-text-description_hide-on-mobile">
                                            Откройте «Настройки содержимого» (chrome://settings/content) или «Настройки»
                                            (chrome://settings/) → «Показать дополнительные настройки» → «Настройки
                                            контента» и&nbsp;включите рекомендуемую опцию «Разрешить всем сайтам
                                            использовать JavaScript».
                                        </p>
                                        <p class="ui-browser-warning__info-text-description ui-browser-warning__info-text-description_show-on-mobile">
                                            Откройте «Настройки» → Выберите «Настройки сайта» → JavaScript и&nbsp;установите
                                            переключатель в&nbsp; рекомендуемый режим «Разрешено».
                                        </p>
                                    </div>
                                </div>
                            </label>
                            <label>
                                <input type="radio" name="browser"
                                       class="ui-browser-warning__info-checker ui-browser-warning__info-checker_opera"
                                       value="Opera">
                                <div class="ui-browser-warning__info-checker-icon ui-browser-warning__info-checker-icon_opera"
                                     data-name="Opera"></div>
                                <div class="ui-browser-warning__info ui-browser-warning__info_opera">
                                    <div class="ui-browser-warning__info-text ui-browser-warning__info-text_opera">
                                        <div class="ui-browser-warning__info-text-title">Для браузера Opera:</div>
                                        <p class="ui-browser-warning__info-text-description">
                                            Меню «Инструменты» → «Настройки…» → «Дополнительно» → «Содержимое» → флаг
                                            «Включить JavaScript».
                                        </p>
                                    </div>
                                </div>
                            </label>
                            <label>
                                <input type="radio" name="browser"
                                       class="ui-browser-warning__info-checker ui-browser-warning__info-checker_ff"
                                       value="Firefox">
                                <div class="ui-browser-warning__info-checker-icon ui-browser-warning__info-checker-icon_ff"
                                     data-name="Firefox"></div>
                                <div class="ui-browser-warning__info ui-browser-warning__info_ff">
                                    <div class="ui-browser-warning__info-text ui-browser-warning__info-text_ff">
                                        <div class="ui-browser-warning__info-text-title">Для браузера Mozilla Firefox:
                                        </div>
                                        <p class="ui-browser-warning__info-text-description">
                                            Меню «Инструменты» → «Настройки…» → «Содержимое» → флаг «Использовать
                                            JavaScript».
                                        </p>
                                    </div>
                                </div>
                            </label>
                            <label>
                                <input type="radio" name="browser"
                                       class="ui-browser-warning__info-checker ui-browser-warning__info-checker_ya"
                                       value="Yandex">
                                <div class="ui-browser-warning__info-checker-icon ui-browser-warning__info-checker-icon_ya"
                                     data-name="Yandex"></div>
                                <div class="ui-browser-warning__info ui-browser-warning__info_ya">
                                    <div class="ui-browser-warning__info-text ui-browser-warning__info-text_ya">
                                        <div class="ui-browser-warning__info-text-title">Для браузера Yandex:</div>
                                        <p class="ui-browser-warning__info-text-description">
                                            «Настройки» → «Показать дополнительные настройки» → В&nbsp;блоке «Защита
                                            личных данных» выбрать «Настройки содержимого» → включить опцию «Разрешить
                                            JavaScript на&nbsp;всех сайтах».
                                        </p>
                                    </div>
                                </div>
                            </label>
                            <label>
                                <input type="radio" name="browser"
                                       class="ui-browser-warning__info-checker ui-browser-warning__info-checker_safari"
                                       value="Safari">
                                <div class="ui-browser-warning__info-checker-icon ui-browser-warning__info-checker-icon_safari"
                                     data-name="Safari"></div>
                                <div class="ui-browser-warning__info ui-browser-warning__info_safari">
                                    <div class="ui-browser-warning__info-text ui-browser-warning__info-text_safari">
                                        <div class="ui-browser-warning__info-text-title">Для браузера Apple Safari:
                                        </div>
                                        <p class="ui-browser-warning__info-text-description ui-browser-warning__info-text-description_hide-on-mobile">
                                            Меню «Safari» → «Свойства» → «Безопасность» → флаг «Включить JavaScript».
                                        </p>
                                        <p class="ui-browser-warning__info-text-description ui-browser-warning__info-text-description_show-on-mobile">
                                            Откройте приложение «Настройки» → Выберите Safari → Дополнения → Включите
                                            переключатель JavaScript.
                                        </p>
                                    </div>
                                </div>
                            </label>
                            <label>
                                <input type="radio" name="browser"
                                       class="ui-browser-warning__info-checker ui-browser-warning__info-checker_ie"
                                       value="Internet Explorer">
                                <div class="ui-browser-warning__info-checker-icon ui-browser-warning__info-checker-icon_ie"
                                     data-name="Internet Explorer"></div>
                                <div class="ui-browser-warning__info ui-browser-warning__info_ie">
                                    <div class="ui-browser-warning__info-text ui-browser-warning__info-text_ie">
                                        <div class="ui-browser-warning__info-text-title">Для браузера Internet
                                            Explorer:
                                        </div>
                                        <p class="ui-browser-warning__info-text-description">
                                            Меню «Сервис» → «Свойства обозревателя» → «Безопасность» → кнопка «Другой» →
                                            строчка «Включить» в&nbsp;пункте «Активные сценарии».
                                        </p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <div class="ui-browser-warning__content-footer ui-browser-warning__content-footer_no-js">По&nbsp;завершении&nbsp;<a
                                    class="ui-browser-warning__link" href="/" rel="nofollow">обновите страницу</a></div>
                    </div>
                </div>
            </div>
        </div>
    </noscript>
</noindex>

<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyBQL00FgROUCp6WZvnPdEdiyhE3f49hYew&callback=mapsInit"></script>
</body>
</html>