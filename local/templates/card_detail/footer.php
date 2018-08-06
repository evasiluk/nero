<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/**
 * @var $APPLICATION CMain
 */
use Astronim\Helper,
    Bitrix\Main\Loader,
    \Bitrix\Main\Localization\Loc;?>

<?//include(DOCUMENT_ROOT . DEFAULT_TEMPLATE_PATH . '/footer.php');?>

<footer class="l-footer flex-row">
    <div class="footer-col col-xs-12 col-sm-12 col-md-6 footmenu flex-row">

        <?Helper::includeFile('template/footer/menu')?>

    </div>
    <div class="footer-col col-xs-12 col-sm-12 col-md-6">

        <?$APPLICATION->IncludeComponent(
            "bitrix:subscribe.form",
            ".default",
            array(
                "CACHE_TIME" => "3600",
                "CACHE_TYPE" => "A",
                "PAGE" => "/local/ajax/subscribe.php",
                "SHOW_HIDDEN" => "N",
                "USE_PERSONALIZATION" => "Y",
                "COMPONENT_TEMPLATE" => ".default"
            ),
            false
        );?>

        <div class="b-site-about flex-row">

            <div class="col-xs-12 col-sm-12 col-md-6">

                <div class="b-socials">

                    <div class="socials-header"><?Helper::includeFile('template/footer/soc_headers')?></div>

                    <? $APPLICATION->IncludeComponent(
                        "bitrix:news.list",
                        "social_networks",
                        array(
                            "ACTIVE_DATE_FORMAT" => "d.m.Y",
                            "ADD_SECTIONS_CHAIN" => "N",
                            "AJAX_MODE" => "N",
                            "AJAX_OPTION_ADDITIONAL" => "",
                            "AJAX_OPTION_HISTORY" => "N",
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "N",
                            "CACHE_FILTER" => "N",
                            "CACHE_GROUPS" => "N",
                            "CACHE_TIME" => "36000000",
                            "CACHE_TYPE" => "A",
                            "CHECK_DATES" => "Y",
                            "DETAIL_URL" => "",
                            "DISPLAY_BOTTOM_PAGER" => "N",
                            "DISPLAY_DATE" => "N",
                            "DISPLAY_NAME" => "N",
                            "DISPLAY_PICTURE" => "N",
                            "DISPLAY_PREVIEW_TEXT" => "N",
                            "DISPLAY_TOP_PAGER" => "N",
                            "FIELD_CODE" => array(
                                0 => "*",
                            ),
                            "FILTER_NAME" => "",
                            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                            "IBLOCK_ID" => "5",
                            "IBLOCK_TYPE" => "content",
                            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                            "INCLUDE_SUBSECTIONS" => "N",
                            "MESSAGE_404" => "",
                            "NEWS_COUNT" => "20",
                            "PAGER_BASE_LINK_ENABLE" => "N",
                            "PAGER_DESC_NUMBERING" => "N",
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                            "PAGER_SHOW_ALL" => "N",
                            "PAGER_SHOW_ALWAYS" => "N",
                            "PAGER_TEMPLATE" => ".default",
                            "PAGER_TITLE" => "Новости",
                            "PARENT_SECTION" => "",
                            "PARENT_SECTION_CODE" => "",
                            "PREVIEW_TRUNCATE_LEN" => "",
                            "PROPERTY_CODE" => array(
                                0 => "",
                                1 => "*",
                                2 => "",
                            ),
                            "SET_BROWSER_TITLE" => "N",
                            "SET_LAST_MODIFIED" => "N",
                            "SET_META_DESCRIPTION" => "N",
                            "SET_META_KEYWORDS" => "N",
                            "SET_STATUS_404" => "N",
                            "SET_TITLE" => "N",
                            "SHOW_404" => "N",
                            "SORT_BY1" => "ID",
                            "SORT_BY2" => "ACTIVE_FROM",
                            "SORT_ORDER1" => "ASC",
                            "SORT_ORDER2" => "DESC",
                            "STRICT_SECTION_CHECK" => "N",
                            "COMPONENT_TEMPLATE" => "index_slider"
                        ),
                        false
                    ); ?>

                </div>

            </div>

            <div class="col-xs-12 col-sm-12 col-md-6">
                <?Helper::includeFile('template/footer/info')?>
            </div>

        </div>


        <div class="b-copyright flex-row">

            <div class="col-xs-12 col-sm-12 col-md-6">
                <?Helper::includeFile('template/footer/developer')?>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6">
                <?Helper::includeFile('template/footer/copy')?>
            </div>

        </div>

    </div>
</footer>