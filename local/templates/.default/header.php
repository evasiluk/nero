<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var $APPLICATION CMain
 * @var $USER CUser
 */

use Astronim\Helper,
    Bitrix\Main\Loader,
    Bitrix\Main\Page\Asset,
    \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
$site = CSite::GetByID(SITE_ID)->GetNext();
?>
<!DOCTYPE HTML>
<html lang="<?= LANGUAGE_ID ?>">
<head>
    <script data-skip-moving="true">
        var DEFAULT_ASSETS_PATH = "<?=DEFAULT_ASSETS_PATH?>";
    </script>
    <meta charset="<?= SITE_CHARSET ?>"/>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" id="viewport" content="width=device-width">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="cache-control" content="max-age=0"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta http-equiv="expires" content="0"/>
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT"/>
    <meta http-equiv="pragma" content="no-cache"/>

    <? $APPLICATION->ShowHead(); ?>
    <title>
        <?php
        if($APPLICATION->GetCurDir() != SITE_DIR) {
            $APPLICATION->ShowTitle(); echo ' &ndash; ';
        }
        echo $site['NAME'];?>
    </title>

    <? Asset::getInstance()->addString('<!--Favicon-->
    <link href="' . DEFAULT_ASSETS_PATH . '/i/icons/favicon.ico" rel="shortcut icon" type="image/x-icon">'); ?>


    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/constructor.js'); ?>
    <? Asset::getInstance()->addString('<script type="text/javascript" src="' . DEFAULT_JS_PATH . '/constructor.js"></script>'); ?>
    <? Asset::getInstance()->addString('<script src="https://www.youtube.com/iframe_api"></script>'); ?>


    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/jquery-2.2.4.min.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/modernizr-custom.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/jquery.tmpl.min.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/jquery.easing.1.3.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/jquery.appear.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/jquery.unveil.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/jquery.stickybits.min.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/jquery.scrollTo.min.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/jquery.fitvids.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/papaparse.min.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/underscore-min.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/list.min.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/ofi.min.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/object-fit-videos.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/js.cookie.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/tippy.all.min.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/parsley.min.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/intersection-observer.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/lozad.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/inputmask.min.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/inputmask.extensions.min.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/jquery.inputmask.min.js'); ?>

    <? Asset::getInstance()->addCss(DEFAULT_JS_PATH . '/lib/fullpage/jquery.fullPage.css'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/fullpage/jquery.fullPage.min.js'); ?>

    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/owl/owl.carousel.min.js'); ?>
    <? Asset::getInstance()->addCss(DEFAULT_JS_PATH . '/lib/owl/owl.carousel.min.css'); ?>
    <? Asset::getInstance()->addCss(DEFAULT_JS_PATH . '/lib/owl/owl.theme.default.min.css'); ?>

    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/choices/scripts/dist/choices.min.js'); ?>
    <? Asset::getInstance()->addCss(DEFAULT_JS_PATH . '/lib/choices/styles/css/choices.min.css'); ?>

    <?
    $portal_regions = array(
        BY_HOST => "by",
        MSK_HOST => "ru",
        SPB_HOST => "ru",
        UA_HOST => "ua"

    );

    $current_reg = $portal_regions[CURRENT_USER_HOST];
    ?>

    <? Asset::getInstance()->addString('<script>
        if (!ie) {
            document.write(\'\x3Cscript src="' . DEFAULT_JS_PATH . '/lib/swiper/js/swiper.min.js">\x3C/script>\');
        }
        var Portal = {region: \''.$current_reg.'\'};
    </script>'); ?>

    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/lightgallery/js/lightgallery-all.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/simplelightbox/simple-lightbox.min.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/videojs/video.min.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/likely/likely.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/slick/slick.min.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/lib/jquery.form.min.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/custom.js'); ?>
    <? Asset::getInstance()->addJs(DEFAULT_JS_PATH . '/common.js'); ?>

    <? Asset::getInstance()->addCss(DEFAULT_JS_PATH . '/lib/lightgallery/css/lightgallery.min.css'); ?>
    <? Asset::getInstance()->addCss(DEFAULT_JS_PATH . '/lib/simplelightbox/simplelightbox.min.css'); ?>
    <? Asset::getInstance()->addCss(DEFAULT_JS_PATH . '/lib/videojs/video-js.css'); ?>
    <? Asset::getInstance()->addCss(DEFAULT_JS_PATH . '/lib/likely/likely.css'); ?>
    <? Asset::getInstance()->addCss(DEFAULT_JS_PATH . '/lib/slick/slick.css'); ?>
    <? Asset::getInstance()->addCss(DEFAULT_JS_PATH . '/lib/slick/slick-theme.css'); ?>
    <? Asset::getInstance()->addCss(DEFAULT_CSS_PATH . '/common.css'); ?>

    <? Asset::getInstance()->addCss(DEFAULT_JS_PATH . '/lib/swiper/css/swiper.min.css'); ?>
    <? Asset::getInstance()->addString('<svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display:none;">

        <symbol id="cnav-1" width="48" height="60" xmlns="http://www.w3.org/2000/svg" viewBox="569.3 228.2 84.3 103">
            <path d="M611.5 297.3c-2.8 0-5 2.2-5 5s2.2 5 5 5 5-2.2 5-5-2.3-5-5-5zm36.2-69.1h-72.5c-3.3 0-5.9 2.7-5.9 5.9v91.1c0 3.3 2.7 5.9 5.9 5.9h72.5c3.3 0 5.9-2.7 5.9-5.9v-91.1c0-3.2-2.6-5.9-5.9-5.9zm2.9 97.1c0 1.6-1.3 2.9-2.9 2.9h-72.5c-1.6 0-2.9-1.3-2.9-2.9v-24.4h11.9v-9.8h54.5v9.8h12v24.4zm0-27.4h-9v-9.8h-60.5v9.8h-8.9v-63.7c0-1.6 1.3-2.9 2.9-2.9h72.5c1.6 0 2.9 1.3 2.9 2.9v63.7zm-71.2-22l.8.4c8 4 19.4 6.3 31.3 6.3s23.3-2.3 31.3-6.3l.8-.4v-37.3h-64.2v37.3zm3-34.3h58.2V274c-7.5 3.5-18.1 5.6-29.1 5.6s-21.6-2-29.1-5.6v-32.4z"/>
        </symbol>

        <symbol id="cnav-2" width="60" height="53" xmlns="http://www.w3.org/2000/svg" viewBox="426.5 232.1 103.4 92.9">
            <path d="M520.4 232.1H436c-5.2 0-9.5 4.3-9.5 9.5 0 4.7 3.5 8.6 8 9.4v67.4c0 3.7 3 6.7 6.7 6.7h81.9c3.7 0 6.7-3 6.7-6.7v-76.7c.1-5.3-4.1-9.6-9.4-9.6zm-84.4 16c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5h77.5c-1.6 1.7-2.6 4-2.6 6.5s1 4.8 2.6 6.5H436zm90.9 70.2c0 2.1-1.7 3.7-3.7 3.7h-81.9c-2.1 0-3.7-1.7-3.7-3.7v-3.8H527v3.8zm0-6.8h-89.4v-7.6h89.4v7.6zm0-10.6h-89.4v-7.6h89.4v7.6zm0-10.5h-89.4v-7.6h89.4v7.6zm0-10.6h-89.4v-7.6h89.4v7.6zm0-10.6h-89.4v-7.6h89.4v7.6zm0-10.5h-89.4v-7.6h82.9c2.5 0 4.8-1 6.5-2.6v10.2zm-6.5-10.6c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5-2.9 6.5-6.5 6.5z"/>
        </symbol>

        <symbol id="cnav-3" width="58" height="53" xmlns="http://www.w3.org/2000/svg" viewBox="688.4 233.3 107.6 98">
            <path d="M743.4 296.4c-5.1 0-9.9 2.6-12.5 6.9-.4.7-.2 1.6.5 2.1.7.4 1.6.2 2.1-.5 2.1-3.4 5.9-5.4 10-5.4s7.9 2.1 10 5.5c.3.5.8.7 1.3.7.3 0 .5-.1.8-.2.7-.4.9-1.4.5-2.1-2.8-4.3-7.6-7-12.7-7zm0-10.8c-7.1 0-13.8 2.8-18.7 7.8-.6.6-.6 1.5 0 2.1.6.6 1.5.6 2.1 0 4.3-4.4 10.3-6.9 16.5-6.9h.1c6.2 0 12.2 2.6 16.5 7 .3.3.7.5 1.1.5.4 0 .8-.1 1-.4.6-.6.6-1.5 0-2.1-4.8-5.1-11.6-8-18.6-8zm-1.2-52.3l-53.8 50.1h17.4v38c0 5.5 4.5 10 10 10h56c5.5 0 10-4.5 10-10v-38H796l-53.8-50.1zm36.5 47.1v41c0 3.8-3.1 7-7 7h-56c-3.8 0-7-3.1-7-7v-41H696l46.2-43 46.2 43h-9.7zm-60.2 3.3c-.6.5-.7 1.5-.2 2.1s1.5.7 2.1.2c13.3-11.1 32.7-11 45.9.1.3.2.6.4 1 .4s.9-.2 1.2-.5c.5-.6.4-1.6-.2-2.1-14.4-12.2-35.3-12.2-49.8-.2z"/>
        </symbol>

        <symbol id="ico-check" height="15" viewBox="0 0 26 15" width="26" xmlns="http://www.w3.org/2000/svg">
            <path d="M18.5 1.5L17 0 11 6.5l1.4 1.4 6.3-6.3zM22.7 0L12.2 10.8 8 6.5 6.6 8l5.6 5.5 12-12L22.7 0zM1 8l5.5 5.5L8 12 2.2 6.6 1 8z" fill-rule="evenodd"/>
        </symbol>

        <symbol id="ico-check-2" fill="none" height="24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 6L9 17l-5-5"/>
        </symbol>

        <symbol id="ico-close" height="32" viewBox="0 0 32 32" width="32" xmlns="http://www.w3.org/2000/svg">
            <g clip-rule="evenodd" fill-rule="evenodd"><path d="M16 0C7.2 0 0 7.2 0 16s7.2 16 16 16 16-7.2 16-16S24.8 0 16 0zm0 30C8.3 30 2 23.7 2 16S8.3 2 16 2s14 6.3 14 14-6.3 14-14 14z"/><path d="M22.7 21.3L17.5 16l5.2-5.2c.4-.4.4-1 0-1.4-.4-.4-1-.4-1.4 0L16 14.6l-5.3-5.3c-.4-.4-1-.4-1.4 0-.4.4-.4 1 0 1.4l5.3 5.3-5.3 5.3c-.4.4-.4 1 0 1.4.4.4 1 .4 1.4 0l5.3-5.3 5.3 5.3c.4.4 1 .4 1.4 0 .4-.4.4-1 0-1.4z"/></g>
        </symbol>

        <symbol id="ico-close-2" enable-background="new 0 0 32 32" height="32px" version="1.1" viewBox="0 0 32 32" width="32px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M17.459,16.014l8.239-8.194c0.395-0.391,0.395-1.024,0-1.414c-0.394-0.391-1.034-0.391-1.428,0  l-8.232,8.187L7.73,6.284c-0.394-0.395-1.034-0.395-1.428,0c-0.394,0.396-0.394,1.037,0,1.432l8.302,8.303l-8.332,8.286  c-0.394,0.391-0.394,1.024,0,1.414c0.394,0.391,1.034,0.391,1.428,0l8.325-8.279l8.275,8.276c0.394,0.395,1.034,0.395,1.428,0  c0.394-0.396,0.394-1.037,0-1.432L17.459,16.014z"/></symbol>

        <symbol id="ico-search" height="50" viewBox="0 0 50 50" width="50" xmlns="http://www.w3.org/2000/svg">
            <circle cx="21" cy="20" fill="none" r="16" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"/>
            <path stroke-miterlimit="10" stroke-width="4" d="M32.2 32.2l13.3 13.3"/>
        </symbol>

        <symbol id="ico-lang" xmlns="http://www.w3.org/2000/svg" viewBox="267.2 14.2 419.7 419.7">
            <path d="M477 433.8c-115.7 0-209.8-94-209.8-209.8S361.2 14.2 477 14.2s209.8 94 209.8 209.8-94 209.8-209.8 209.8zm75-143c-8.6 37-22.6 72.5-41.5 105.4C568.2 385 616 346 638.8 291.6L552 291zm-237.2 0c22.6 54.7 70.6 94 128.6 105.3-19-33-33-68.5-41.6-105.8h-11.3c-36 0-61 .2-75.7.5zm122.4-.5c8.7 33.4 22 65.3 39.8 95 17.7-29.6 31-61.4 39.7-94.7l-79.5-.3zm120.6-33.7c22.6 0 43 .3 59.6.5l31.7.3c4.3-21.6 4.4-43.5.4-65.2l-91.3-.6c1.3 10.8 2 21.8 2 32.6-.2 11-1 21.8-2.2 32.6zm-253-65.2c-4 21.5-4.2 43.8 0 65.3 12.5-.7 35.5-1 78.8-1H396c-2.4-21.5-2.4-43.4 0-65h-4.3c-54.4 0-77.6.3-87 .7zM478.3 256l45 .3c1.5-10.7 2.2-21.6 2.2-32.3 0-10.8-.8-21.8-2.2-32.6-32.7-.2-63.7-.4-92.6-.4-3 21.6-3 43.5-.2 65h47.8zM552 157c17.5 0 33.8.3 48.2.4 16 0 29.2.3 39 .3-22.4-55-70.5-94.3-128.5-105.6 19 32.7 32.8 68 41.4 104.8zm-108.6-105C385.6 63.3 337.7 102.3 315 157c16-.5 42.7-.6 87-.6 8.7-36.6 22.6-71.7 41.4-104.3zm35 104.7l38 .2c-8.6-33-22-64.6-39.4-94-17.5 29.3-30.7 60.7-39.3 93.6l40.6.2z"/>
        </symbol>

        <symbol id="ico-user" xmlns="http://www.w3.org/2000/svg" width="400" height="382.5" viewBox="0 0 400 382.5">
            <path d="M244 213.8C276 195 297.6 157 297.6 113 297.5 50.6 254 0 200 0s-97.3 50.6-97.3 113c0 44 21.6 82 53 100.6C27.7 226.4 0 297.2 0 382.6h400c0-85-34-155.6-156-168.8z"/>
        </symbol>

        <symbol id="ico-logo" xmlns="http://www.w3.org/2000/svg" width="380.6" height="76.2" viewBox="0 0 380.6 76.2">
            <path d="M64.6 1.2c-3.3.5-5.6 3.7-5.6 7v43c0 .2-.2.3-.3.2l-47-48.2c-2-2-5-2.6-7.5-1.6S0 5.2 0 8v60.3c0 4 3.7 7.4 8 6.7 3.2-.5 5.5-3.7 5.5-7V25c0-.2.2-.2.3 0l47 48c1.3 1.4 3 2.2 5 2.2.7 0 1.6-.2 2.4-.5 2.5-1 4.2-3.5 4.2-6.3V8c0-4.2-3.6-7.5-7.8-6.8zM116 14.7h51.4c3.4 0 6.5-2.3 7-5.6.7-4.2-2.6-7.8-6.7-7.8h-59c-3.7 0-6.8 3-6.8 6.8v60.4c0 3.7 3 6.8 6.7 6.8h58.6c3.4 0 6.5-2.3 7-5.6.7-4.3-2.6-8-6.7-8H116c-.4 0-.6 0-.6-.4V45.4c0-.3.2-.5.5-.5h51.6c4 0 7.4-3.8 6.7-8-.5-3.3-3.7-5.6-7-5.6H116c-.4 0-.6-.2-.6-.5V15c.2-.3.4-.5.7-.5zm257.7 1.7V16l3.8-4c2.6-2.6 3.2-6.4 1.2-9-2.5-3.6-7.4-3.8-10.3-1L364 6.5c0 .2-.3.2-.5 0-7.7-5-17.4-7.5-27.7-5.7-15.7 2.7-28.3 15.3-31 31-4.3 26 18 48.4 44 44 16-2.5 28.7-15.3 31.3-31 1.7-10.7-1-20.5-6.3-28.3zm-36 45.8c-9.8-1.8-17.6-9.7-19.4-19.3-3.3-17.4 11.7-32.4 29-29 4.7.8 9 3 12.3 6.4l.3.3c3.3 3.4 5.7 7.7 6.6 12.5 3.3 17.4-11.7 32.4-29 29zm-76-13.8V48c8.8-4.2 14.6-13.4 14-23.8-1-13-12.5-23-25.7-23h-39c-3.7 0-6.8 3-6.8 6.7v60c0 3.5 2.3 6.6 5.6 7 4.2.8 8-2.5 8-6.6V51c0-.3 0-.5.4-.5h27.1C247 52.6 266 73 266 73c1.3 1.5 3.2 2.2 5 2.2 1.5 0 3-.5 4.2-1.5 3-2.5 3-7.3.4-10.2l-14-15zM251 37h-32.7c-.3 0-.5-.2-.5-.5V15.2c0-.3.2-.5.5-.5h32.4c5.3 0 10.2 3.6 11.2 8.8 1.4 7.2-4 13.5-11 13.5z"/>
        </symbol>

        <symbol id="ico-placemark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 300">
            <path d="M154.1 0c15.8-.2 30.6 4.1 44.6 11 16.4 8 30.3 19.1 41.2 34.1 13.4 18.5 22.3 38.7 22.9 61.7v6.1c-.3 3.5-.5 7.1-1.1 10.6-2.8 15.7-7.9 30.7-14.7 45.1-10.4 22-23.3 42.7-38.1 61.9-14.3 18.5-29.8 36.2-44.8 54.1-4.5 5.3-9.3 10.4-14 15.5h-1c-4.7-5.2-9.4-10.2-14-15.5-12-13.9-24.4-27.4-35.7-41.9-19.7-25.4-38.2-51.8-50.5-81.8-4.5-11-8.2-23.8-10.5-34.1-1-4.5-1.1-17.6-1.1-18.9-.1-15.8 4-30.6 10.9-44.6C56.3 46.9 67.3 33 82.3 22.2 100.7 8.5 121 .6 143.9 0h10.2zm-4.6 150c20.9 1.7 36.9-17.3 38-34.7 1.6-24.8-18.2-40.1-35.5-41.1-24.1-1.4-39.6 18.2-40.6 35.5-1.3 23.7 18.2 42.1 38.1 40.3z"/>
        </symbol>

        <symbol id="ico-placemark-outline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 338.7 460.7">
            <path d="M334.6 138.3C319.9 72.6 280.2 28 215.6 7c-11.1-3.6-23.1-5-34.6-7h-24c-11.1 2-22.5 3.1-33.2 6.5C57.5 27.7 18 73.4 3.1 140.9 1.7 147.5 1 154.3 0 161v22c0 1.3.7 2.5.8 3.8C3.7 218 14.4 246.4 32.3 272 75 333.2 118 394.2 160.5 455.5c4.8 6.9 13.1 7.2 18 .1 42-60.9 84.5-121.4 126.6-182.1 28.4-41 40.6-86.1 29.5-135.2zm-43.3 123.1c-39.3 58-80 115.2-120 172.7-.6.8-1.2 1.6-2.2 3-1.3-1.8-2.3-3-3.3-4.4-39.6-56.6-79.4-113.1-118.9-169.8-21.3-30.5-31.9-64.3-28.8-101.7 5.4-64.4 54-132 131.7-142.1 62.3-8 121.6 23.1 151.1 80.2 28.8 55.7 25.4 110.4-9.6 162.1zM164.6 104c-35.7 1.5-65 34.3-63.4 71 1.6 37.2 33.3 67.1 69.5 65.6 38.2-1.6 67.7-33.2 66.2-70.9-1.7-38.5-33.4-67.3-72.3-65.7zm4.4 118.6c-27.4.1-50-22.9-49.9-50.6.1-27.8 22.6-50.3 50.3-50.1 27.3.1 49.6 22.9 49.4 50.5-.1 27.5-22.5 50.1-49.8 50.2z"/>
        </symbol>

        <symbol id="ico-phone" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 505.8 493.9">
            <path d="M419.4 277.1c1.8 1.8 4 2.8 6.1 2.8s4.3-1 6.1-2.8c1.8-1.8 2.8-4 2.7-6.1v-.1c0-109.9-89.4-199.3-199.4-199.3-3.3 0-5.6 1.9-6.7 3-1.8 1.9-3 4.3-3 6.5.3 4.2 4.7 8.3 9 8.3h.7c100.2 0 181.6 81.5 181.6 181.6v.1c.1 2 1.1 4.2 2.9 6zm-27.1 66.8c-11.7-8.6-23.8-17.4-35.2-26.6-8.2-4.3-15.8-6.5-22.7-6.5-3.1 0-6.1.5-8.9 1.4-9.2 3.1-14.8 9.4-19.7 14.9l-.8.9c-15.1 16.8-29.7 24.6-46.2 24.6-1.7 0-3.4-.1-5.2-.3h-.2c-15.6-1.8-31.6-10.6-45.1-24.8l-41.9-41.9c-14.2-13.5-23-29.6-24.7-45.1v-.2c-1.8-18.5 6-34.9 24.4-51.4l.8-.8c5.5-5 11.8-10.6 14.9-19.7 3.7-11-.6-23.1-5.1-31.6-9.2-11.5-18.1-23.5-26.6-35.2-10.5-14.4-20.5-27.9-30.3-39.4-7.1-7-17.1-11.2-26.8-11.2-3.1 0-6 .4-8.7 1.3-11.1 3.4-20 11.4-27.4 18.6-44.4 44.4-63 89.8-55.2 134.8 7.2 41.6 34.6 84.4 88.9 138.7l58.9 58.9c54.3 54.3 97.1 81.7 138.7 88.9 6.7 1.2 13.5 1.7 20.2 1.7 38.2 0 76.8-19.2 114.6-56.9 7.2-7.4 15.2-16.2 18.6-27.4 2.9-9.3 1-24.3-9.9-35.5-11.5-9.8-25.1-19.7-39.4-30.2zm32.6 59.8c-.1.2-.1.4-.2.7-2.3 7.5-11.4 17.2-14.1 20l-.1.1c-12.3 12.3-55.9 52.5-101.7 52.5-6.2 0-12.2-.7-17.9-2.2-36.7-6.5-78.9-34-128.9-84l-58.9-58.9c-50-50-77.5-92.2-84-128.9C5.9 151.7 54.3 98.5 69.4 83.4l.1-.1c2.8-2.7 12.5-11.7 20-14.1 1.9-.6 3.6-.9 5.3-.9 7.1 0 11.4 5.2 12.8 6.9l.1.1 52.8 69 .4.7c4.3 8.3 5.4 13.4 4 17.8-.4 1.1-1.5 4.6-10.7 12.8-21.4 19.2-32.4 43.3-30.2 66.4 2.4 24.7 17.4 44 29.7 56l42.3 42.3c11.9 12.2 31.3 27.3 56 29.7 1.9.2 3.9.3 5.9.3 21.4 0 42.9-10.8 60.5-30.5 8.2-9.1 11.7-10.3 12.8-10.7 1.2-.4 2.5-.6 3.8-.6 3.6 0 7.9 1.4 14 4.6l.7.4 69.4 53.1.4.5c4.7 4.8 7.9 8.9 5.4 16.6zm80.9-132.9C505.8 121.5 384.3 0 235.1 0c-2.5 0-5 1.2-7 3.2-1.8 1.8-2.9 4.2-2.9 6.3.3 4.2 4.7 8.3 9 8.3h.7C374.4 17.8 488 131.3 488 270.9v.1c0 2.1 1 4.3 2.8 6.2 1.8 1.8 4 2.8 6.1 2.8s4.3-1 6.1-2.8 2.8-4 2.7-6.1l.1-.3z"/>
        </symbol>

        <symbol id="ico-fax" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 595.2 541.5">
            <path d="M470.1 451.3H125.2c-5.8 0-10.6 4.8-10.6 10.6s4.8 10.6 10.6 10.6h344.9c5.8 0 10.6-4.8 10.6-10.6s-4.8-10.6-10.6-10.6zm97.4-206.9h-86.8V137.9c-.1-2.7-1.4-5.5-3.5-7.4L349.5 3c-2-1.9-4.6-3-7.3-3H142.5c-15.3 0-27.8 12.5-27.8 27.9v216.6H27.8C12.5 244.4 0 256.9 0 272.3v241.4c0 15.3 12.5 27.8 27.8 27.8h539.6c15.3 0 27.8-12.5 27.8-27.8V272.3c.1-15.4-12.4-27.9-27.7-27.9zM342.7 26.1L454.6 138H342.7V26.1zm-206.9-4.9h185.7v110.1c0 15.3 12.5 27.8 27.8 27.8h110.1v154.3H135.8V21.2zm438.3 499.1H21.2V265.6h93.4v69h366v-69H574l.1 254.7z"/>
        </symbol>

        <symbol id="ico-mail" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 485.1 299">
            <path d="M485.1 8.4c0-.3 0-.6-.1-.9 0-.3-.1-.6-.2-.8-.1-.3-.2-.5-.3-.8s-.2-.6-.3-.8-.2-.5-.4-.7c-.2-.3-.4-.6-.6-.8-.1-.1-.1-.2-.2-.3l-.3-.3c-.2-.2-.4-.5-.7-.7-.2-.2-.4-.4-.6-.5-.2-.2-.5-.3-.7-.5-.2-.1-.5-.3-.7-.4-.3-.1-.5-.2-.8-.3s-.5-.2-.8-.3-.6-.1-.9-.2c-.3 0-.6-.1-.9-.1H8.5c-.3 0-.6 0-.9.1-.3 0-.6.1-.9.2-.3.1-.5.2-.8.3s-.6.2-.8.3c-.3.1-.5.3-.7.4-.3.2-.5.3-.7.5s-.4.3-.6.5c-.2.2-.5.4-.7.7l-.3.3s-.1.2-.2.3c-.2.3-.4.5-.6.8-.1.2-.3.5-.4.7-.1.3-.2.6-.3.8-.1.3-.2.5-.3.8s-.1.6-.2.8c0 .3-.1.6-.1.9v281.7c0 4.9 4 8.9 8.9 8.9h467.3c4.9 0 8.9-4 8.9-8.9V8.8v-.4zm-33.9 9.3L242.5 188.6 33.9 17.7h417.3zM17.8 281.1V27.7L236.9 207c1.6 1.3 3.6 2 5.7 2s4-.7 5.7-2L467.4 27.6v253.5H17.8z"/>
        </symbol>

        <symbol id="ico-list" viewBox="0 0 18 12" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 12h18v-2H0v2zm0-5h18V5H0v2zm0-7v2h18V0H0z" fill-rule="evenodd"/>
        </symbol>

        <symbol id="ico-play" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <circle cx="12" cy="12" fill="none" r="10" stroke="#c3143c" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
            <polygon fill="none" points="10 8 16 12 10 16 10 8" stroke="#c3143c" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
        </symbol>

        <symbol id="ico-sound" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M19.779 3.349l-1.111 1.664C20.699 6.663 22 9.179 22 12c0 2.822-1.301 5.338-3.332 6.988l1.111 1.663C22.345 18.639 24 15.516 24 12c0-3.515-1.654-6.638-4.221-8.651zM17.55 6.687l-1.122 1.68c.968.913 1.58 2.198 1.58 3.634s-.612 2.722-1.58 3.635l1.122 1.68C19.047 16.03 20 14.128 20 12c0-2.127-.952-4.029-2.45-5.313zM12 1c-1.177 0-1.533.684-1.533.684S7.406 5.047 5.298 6.531C4.91 6.778 4.484 7 3.73 7H2C.896 7 0 7.896 0 9v6c0 1.104.896 2 2 2h1.73c.754 0 1.18.222 1.567.469 2.108 1.484 5.169 4.848 5.169 4.848S10.823 23 12 23c1.104 0 2-.895 2-2V3c0-1.105-.896-2-2-2z" clip-rule="evenodd"/>
        </symbol>

        <symbol id="ico-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
            <path d="M35 47.25l2.086-2.086L16.922 25 37.086 4.836 35 2.75 12.75 25z"/>
        </symbol>

        <symbol id="ico-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
            <path d="M15 2.75l-2.086 2.086L33.078 25 12.914 45.164 15 47.25 37.25 25z"/>
        </symbol>

        <symbol id="ico-up" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="none" d="M3 15.5l9-9 9 9"/>
        </symbol>

        <symbol id="ico-down" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="none" d="M21 8.5l-9 9-9-9"/>
        </symbol>

        <symbol id="ico-basket" viewBox="285.2 46.1 389.5 355.8">
            <path d="M439.2 328.9c-20.1 0-36.5 16.4-36.5 36.5s16.4 36.5 36.5 36.5 36.5-16.4 36.5-36.5-16.3-36.5-36.5-36.5zm0 50.6c-7.8 0-14.1-6.3-14.1-14.1s6.3-14.1 14.1-14.1 14.1 6.3 14.1 14.1-6.3 14.1-14.1 14.1zm117.4-50.6c-20.1 0-36.5 16.4-36.5 36.5s16.4 36.5 36.5 36.5 36.5-16.4 36.5-36.5-16.4-36.5-36.5-36.5zm0 50.6c-7.8 0-14.1-6.3-14.1-14.1s6.3-14.1 14.1-14.1 14.1 6.3 14.1 14.1-6.4 14.1-14.1 14.1zm116.1-244.8c-2.1-3-5.5-4.7-9.1-4.7H369l-19.8-75.6c-1.3-4.9-5.7-8.4-10.8-8.4h-42c-6.2 0-11.2 5-11.2 11.2 0 6.2 5 11.2 11.2 11.2h33.3l63.6 242.7c1.3 4.9 5.7 8.4 10.8 8.4h203.5c6.2 0 11.2-5 11.2-11.2 0-6.2-5-11.2-11.2-11.2H412.8l-8.1-30.8h219c4.8 0 9-3 10.6-7.5l39.9-114c1.1-3.3.6-7.1-1.5-10.1zM615.8 244H398.9l-24-91.6h272.9l-32 91.6z"/>
        </symbol>

        <symbol id="ico-filter" xmlns="http://www.w3.org/2000/svg" viewBox="380 180 200 200">
            <path d="M417.778 219.629c1.361-.008 1.98.399 2.443 1.728 4.313 12.377 15.929 20.603 29.096 20.708 12.821.103 24.666-8.045 29.068-20.195.648-1.788 1.457-2.253 3.245-2.25 29.243.052 58.486.037 87.729.037h2.388v-17.246h-2.518c-29.179 0-58.358-.012-87.538.03-1.722.002-2.627-.317-3.295-2.182-4.355-12.167-16.187-20.334-29.014-20.258-13.171.078-24.869 8.321-29.142 20.642-.486 1.402-1.146 1.811-2.583 1.801-9.066-.065-18.133-.035-27.2-.029-.732.001-1.464.061-2.129.091v17.151h2.441c9.004 0 18.007.027 27.009-.028zm31.657-22.386c7.548-.014 13.726 6.184 13.729 13.774.003 7.596-6.159 13.805-13.703 13.806-7.661.002-13.915-6.255-13.869-13.875.046-7.548 6.25-13.69 13.843-13.705zm29.217 91.349c1.568-.002 2.307.408 2.866 1.974 4.377 12.25 15.973 20.412 28.873 20.468 13.038.057 24.759-7.993 29.234-20.248.608-1.664 1.289-2.228 3.068-2.208 8.938.1 17.878.046 26.817.046h2.178v-17.246h-2.42c-8.875 0-17.751-.047-26.625.042-1.672.017-2.386-.458-2.967-2.073-4.426-12.28-16.119-20.396-29.138-20.38-12.925.016-24.596 8.134-28.974 20.325-.617 1.717-1.435 2.127-3.143 2.124-29.243-.052-58.487-.038-87.73-.038h-2.45v17.246h2.682c29.242 0 58.486.011 87.729-.032zm31.93-22.383c7.563-.012 13.793 6.167 13.832 13.719.039 7.623-6.244 13.897-13.883 13.864-7.577-.033-13.701-6.213-13.693-13.82.007-7.6 6.151-13.751 13.744-13.763zm58.491 74.135c-29.243 0-58.487-.012-87.73.032-1.565.002-2.306-.402-2.866-1.972-4.391-12.316-16.043-20.465-29.06-20.47-13.013-.005-24.713 8.134-29.105 20.419-.594 1.661-1.374 2.043-3 2.029-8.938-.077-17.878-.037-26.817-.037h-2.18v17.246h2.418c8.875 0 17.751.048 26.625-.042 1.679-.017 2.384.473 2.963 2.081 4.369 12.13 15.979 20.288 28.765 20.371 12.985.084 24.731-7.844 29.21-19.984.753-2.042 1.701-2.47 3.678-2.466 29.116.06 58.232.042 87.347.042h2.439v-17.246c-1.048-.003-1.867-.003-2.687-.003zm-119.715 22.414c-7.551-.011-13.765-6.23-13.77-13.781-.005-7.637 6.272-13.854 13.936-13.802 7.567.051 13.67 6.257 13.641 13.871-.03 7.579-6.217 13.724-13.807 13.712z"/>
        </symbol>

        <symbol id="ico-reset" xmlns="http://www.w3.org/2000/svg" viewBox="380 180 200 200">
            <path d="M482.278 198.721v-3.912c0-3.721.019-7.443-.008-11.164-.011-1.514.399-2.737 1.898-3.373 1.576-.667 2.759-.036 3.865 1.083 7.886 7.98 15.79 15.943 23.687 23.913 2.776 2.801 5.559 5.595 8.318 8.413 1.795 1.834 1.799 3.559.004 5.355-10.676 10.69-21.367 21.364-32.035 32.061-1.138 1.141-2.391 1.618-3.905.998-1.51-.619-1.84-1.911-1.833-3.412.024-5.61.009-11.219.009-16.829v-1.891c-6.707-.142-13.166.373-19.444 2.148-23.198 6.558-36.84 21.909-41.086 45.506-2.385 13.254-1.12 26.277 4.555 38.596 7.826 16.987 21.297 27.12 39.422 30.949 14.154 2.99 28.12 1.989 41.368-4.143 17.093-7.912 27.15-21.541 30.891-39.823.961-4.696 1.146-9.574 1.406-14.384.395-7.308 5.739-13.668 12.778-14.859 7.512-1.27 14.68 2.578 17.329 9.555.75 1.975 1.169 4.213 1.143 6.323-.248 20.214-7.045 38.151-19.472 53.939-13.673 17.372-31.161 29.114-52.82 34.048-22.535 5.134-43.75 1.096-63.293-10.921-22.854-14.052-37.902-34.085-43.715-60.472-4.715-21.407-.893-41.678 10.133-60.436 13.726-23.351 33.715-38.683 60.193-45.177 6.657-1.633 13.45-2.242 20.612-2.091z"/>
        </symbol>

        <symbol id="ico-delivery" xmlns="http://www.w3.org/2000/svg" viewBox="27.64 76.535 540 540">
            <path d="M459.037 508.937c-21.857 0-41.035-14.709-46.909-35.866H243.116c-5.865 21.157-25.12 35.866-47.097 35.866-21.857 0-41.036-14.709-46.909-35.866H94.398c-3.653-.001-6.981-3.329-6.982-6.982v-83.687c0-3.85 3.132-6.982 6.982-6.982s6.982 3.132 6.982 6.982v76.706h45.823c.536-26.462 22.228-47.822 48.816-47.822s48.28 21.36 48.816 47.822h165.387c.536-26.462 22.228-47.822 48.816-47.822s48.28 21.36 48.817 47.822h45.823v-125.7l-91.068-34.127c-1.435-.532-2.674-1.539-3.487-2.836l-63.582-98.348H94.398c-3.85 0-6.982-3.132-6.982-6.982s3.132-6.982 6.982-6.982h304.863c2.341.008 4.653 1.292 5.895 3.273l64.446 99.648 93.463 35.004c2.686.983 4.57 3.674 4.575 6.543V466.09c0 3.653-3.327 6.98-6.981 6.981h-54.524c-5.864 21.158-25.12 35.866-47.098 35.866zm0-83.688c-19.223 0-34.862 15.639-34.862 34.862s15.639 34.862 34.862 34.862 34.862-15.639 34.862-34.862-15.639-34.862-34.862-34.862zm-263.018 0c-19.223 0-34.862 15.639-34.862 34.862s15.639 34.862 34.862 34.862 34.862-15.639 34.862-34.862-15.639-34.862-34.862-34.862zM70.488 341.562c-3.85 0-6.982-3.132-6.982-6.982s3.132-6.982 6.982-6.982h131.254c3.85 0 6.982 3.132 6.982 6.982s-3.132 6.982-6.982 6.982H70.488zM46.577 293.74c-3.85 0-6.982-3.132-6.982-6.982s3.132-6.982 6.982-6.982h155.165c3.85 0 6.982 3.132 6.982 6.982s-3.132 6.982-6.982 6.982H46.577zm-11.955-47.822c-3.85 0-6.982-3.132-6.982-6.982s3.132-6.982 6.982-6.982h167.12c3.85 0 6.982 3.132 6.982 6.982s-3.132 6.982-6.982 6.982H34.622z"/>
        </symbol>

        <symbol id="ico-catalog" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 0h4v4H0zM6 0h4v4H6zM12 0h4v4h-4zM0 6h4v4H0zM6 6h4v4H6zM12 6h4v4h-4zM0 12h4v4H0zM6 12h4v4H6zM12 12h4v4h-4z"/>
        </symbol>

        <symbol id="ico-attachement" viewBox="54.4 224.7 348.2 355.2">
            <path d="M319.5 478.9h-89.9l60.3-60.3-14.1-14.1-37.2 37.2V317.9h-20v123.8l-37.2-37.2-14.1 14.1 60.3 60.3h-89.9v20h182v-20zM54.4 224.7v355.2h348.2V224.7H54.4zM384.8 562H72.3V242.5h312.5V562z"/>
        </symbol>

        <symbol id="ico-lock" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
            <path d="M16 21.9146v2.5944c0 .2712.232.491.5.491.2761 0 .5-.2279.5-.491v-2.5944c.5826-.2059 1-.7615 1-1.4146 0-.8284-.6716-1.5-1.5-1.5s-1.5.6716-1.5 1.5c0 .6531.4174 1.2087 1 1.4146zM9 14v-3.5008C9 6.3567 12.3579 3 16.5 3c4.1337 0 7.5 3.3575 7.5 7.4992V14c1.6591.0047 3 1.3503 3 3.0095v9.981C27 28.6634 25.653 30 23.9912 30H9.0088C7.3456 30 6 28.6526 6 26.9905v-9.981c0-1.67 1.3423-3.0048 3-3.0095zm3 0v-3.4991C12 8.0092 14.0147 6 16.5 6c2.4802 0 4.5 2.0151 4.5 4.5009V14h-9z" fill-rule="evenodd"/>
        </symbol>

        <symbol id="ico-clock" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
            <path d="M25 49.945c-13.784 0-25-11.215-25-24.998C0 11.222 11.216.055 25 .055s25 11.167 25 24.892c0 13.783-11.216 24.998-25 24.998zm0-45.287c-11.246 0-20.397 9.102-20.397 20.289 0 11.245 9.151 20.395 20.397 20.395s20.397-9.15 20.397-20.395C45.397 13.76 36.246 4.658 25 4.658z"/>
            <path d="M33.989 32.709c-.406 0-.82-.107-1.192-.334l-8.992-5.46a2.304 2.304 0 0 1-1.107-1.968V10.814a2.301 2.301 0 1 1 4.604 0v12.838l7.885 4.787a2.3 2.3 0 0 1-1.198 4.27z"/>
        </symbol>

        <symbol id="ico-pdf" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
            <path d="M377.67,450H148.8a50.17,50.17,0,0,1-50.11-50.11V98.11A50.17,50.17,0,0,1,148.8,48H298.9a15,15,0,0,1,10.6,4.39L423.38,166.27a15,15,0,0,1,4.4,10.61v223A50.17,50.17,0,0,1,377.67,450ZM148.8,78a20.13,20.13,0,0,0-20.11,20.11V399.89A20.13,20.13,0,0,0,148.8,420H377.67a20.13,20.13,0,0,0,20.11-20.11V183.09L292.68,78Z"/>
            <path d="M412.78,191.88H334a50.17,50.17,0,0,1-50.11-50.11V63a15,15,0,0,1,30,0v78.77A20.13,20.13,0,0,0,334,161.88h78.77a15,15,0,0,1,0,30Z"/>
            <path d="M156,267.36c0-3.31,3-6.22,7.68-6.22H191c17.47,0,31.24,8.21,31.24,30.45v.66c0,22.24-14.3,30.71-32.57,30.71H176.6v28.59c0,4.24-5.16,6.35-10.33,6.35S156,355.79,156,351.55Zm20.65,11.78v27.93h13.1c7.41,0,11.92-4.23,11.92-13.23v-1.46c0-9-4.51-13.24-11.92-13.24Z"/>
            <path d="M263.69,261.14c18.27,0,32.57,8.47,32.57,31.24v34.29c0,22.76-14.3,31.23-32.57,31.23H240.26c-5.42,0-9-2.91-9-6.22V267.36c0-3.31,3.58-6.22,9-6.22Zm-11.78,18V339.9h11.78c7.42,0,11.92-4.23,11.92-13.23V292.38c0-9-4.5-13.24-11.92-13.24Z"/>
            <path d="M309.36,267.5c0-4.24,4.5-6.36,9-6.36h45.93c4.37,0,6.23,4.64,6.23,8.87,0,4.9-2.25,9.13-6.23,9.13H330v22.38h20c4,0,6.22,3.83,6.22,8.07,0,3.57-1.85,7.81-6.22,7.81H330v34.15c0,4.24-5.16,6.35-10.32,6.35s-10.33-2.11-10.33-6.35Z"/>
        </symbol>

    </svg>'); ?>
</head>
<div class="newsite js-newsite">
    <div class="newsite-close js-newsite-close">
        <svg class="ico-close" viewBox="0 0 32 32">
            <use xlink:href="#ico-close"></use>
        </svg>
    </div>
    <p><img src="<?=DEFAULT_ASSETS_PATH?>/i/icons/23.png" alt=""></p>
    <h4>Сайт Nero Electronics находится в разработке.</h4>
    <p>На данный момент доступны основные разделы сайта.<br>Заранее приносим извинения за неудобства.</p>
</div>
<body>
<script>
    document.body.className += ' js';
</script>
<? if (CTopPanel::shouldShowPanel()): ?>
    <style type="text/css">
        #bx-panel-container {
            display: none;
            position: fixed;
            z-index: 999;
            width: 100%;
        }

        #bx-panel-controller {
            display: block;
            width: 64px;
            height: 64px;
            position: fixed;
            background: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjY0cHgiIGhlaWdodD0iNjRweCIgdmlld0JveD0iMCAwIDU3OS4xNiA1NzkuMTYiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDU3OS4xNiA1NzkuMTY7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNNTY5Ljk3OSwzNTMuODQxaDkuMTgxdi05LjE4di0xMDcuMXYtOS4xOGgtOS4xODFINDk3LjFjLTQuMjg3LTE0LjY2OS0xMC4xMjgtMjguODU5LTE3LjQzMy00Mi4zMzhsNTEuNDYtNTEuNDYgICAgbDYuNDktNi40OWwtNi40OS02LjQ5bC03NS43MzEtNzUuNzMybC02LjQ5LTYuNDk0bC02LjQ5MSw2LjQ5NGwtNTEuNjQ5LDUxLjY0OWMtMTIuNzgxLTYuODQ4LTI2LjE4Mi0xMi4zOTktMzkuOTg1LTE2LjU2MVY5LjE4MiAgICB2LTkuMThoLTkuMThIMjM0LjVoLTkuMTh2OS4xOHY3MS43ODFjLTEzLjEwOSwzLjk1NC0yNS44MzksOS4xNDYtMzcuOTkzLDE1LjQ5bC01MC41ODItNTAuNTgybC02LjQ5LTYuNDk0bC02LjQ5LDYuNDk0ICAgIEw0OC4wMzMsMTIxLjZsLTYuNDksNi40OWw2LjQ5LDYuNDkxbDQ5LjQ4Myw0OS40ODNjLTcuMzE2LDEzLjE1NS0xMy4yMjUsMjYuOTgtMTcuNjMxLDQxLjI1NUg5LjE4SDB2OS4xOHYxMDcuMXY5LjE4MWg5LjE4SDc5ICAgIGM0LjQ5NSwxNS4zNzksMTAuNzA0LDMwLjIzMiwxOC41MjIsNDQuMzA5bC00OS40ODksNDkuNDg5bC02LjQ5LDYuNDlsNi40OSw2LjQ5bDc1LjczMiw3NS43MzJsNi40OSw2LjQ5M2w2LjQ5LTYuNDkzICAgIGw1MC41NzktNTAuNTc5YzEzLjA2LDYuODMzLDI2LjgyMSwxMi4zMTYsNDEuMDU2LDE2LjM1OHY3MC45MDl2OS4xODFoOS4xOEgzNDQuNjZoOS4xOHYtOS4xODF2LTcyLjcyNCAgICBjMTIuNzI3LTQuMDMzLDI1LjEwMi05LjI2MywzNi45MzEtMTUuNjA4bDUxLjY0NSw1MS42NGw2LjQ5LDYuNDk0bDYuNDktNi40OTRsNzUuNzMxLTc1LjczMWw2LjQ5LTYuNDlsLTYuNDktNi40OWwtNTEuNDYtNTEuNDYgICAgYzYuODE0LTEyLjU2NywxMi4zNTYtMjUuNzMxLDE2LjU0Mi0zOS4yNzhoNzMuNzcxVjM1My44NDF6IE00MTguMSwyODkuNTgyYzAsNzEuNzExLTU4LjMzOSwxMzAuMDUtMTMwLjA1LDEzMC4wNSAgICBTMTU4LDM2MS4yOTIsMTU4LDI4OS41ODJzNTguMzM5LTEzMC4wNSwxMzAuMDUtMTMwLjA1UzQxOC4xLDIxNy44NzEsNDE4LjEsMjg5LjU4MnoiIGZpbGw9IiM1ODZkN2MiLz4KCTwvZz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K);
            left: 25px;
            bottom: 25px;
            z-index: 99;
            cursor: pointer;

            -webkit-transition: all 0.3s 0s ease-in-out;
            -moz-transition: all 0.3s 0s ease-in-out;
            -o-transition: all 0.3s 0s ease-in-out;
            -ms-transition: all 0.3s 0s ease-in-out;
            transition: all 0.3s 0s ease-in-out;

            opacity: 0.4;
        }

        #bx-panel-controller:hover {
            opacity: 1;

            -webkit-animation-name: rotate;
            -webkit-animation-duration: 5s;
            -webkit-animation-iteration-count: infinite;
            -webkit-animation-timing-function: linear;
            -moz-animation-name: rotate;
            -moz-animation-duration: 3s;
            -moz-animation-iteration-count: infinite;
            -moz-animation-timing-function: linear;
        }

        @-webkit-keyframes rotate {
            from {
                -webkit-transform: rotate(0deg);
            }
            to {
                -webkit-transform: rotate(360deg);
            }
        }
    </style>
    <script>
        $(document).ready(function () {
            if (getCookie('bx_panel_is_opened') == 1)
                $('#bx-panel-container').show();
            else
                setCookie('bx_panel_is_opened', -1);

            $('#bx-panel-controller').click(function () {
                $('#bx-panel-container').toggle(function () {
                    setCookie('bx_panel_is_opened', getCookie('bx_panel_is_opened') * -1);
                });
            });
        });

        function setCookie(name, value, days) {
            var expires;

            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toGMTString();
            } else {
                expires = "";
            }
            document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
        }

        function getCookie(name) {
            var nameEQ = encodeURIComponent(name) + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) === 0) return decodeURIComponent(c.substring(nameEQ.length, c.length));
            }
            return null;
        }

        function deleteCookie(name) {
            createCookie(name, "", -1);
        }
    </script>
    <div id="bx-panel-controller"></div>
    <div id="bx-panel-container">
        <? $APPLICATION->ShowPanel() ?>
    </div>
<? endif; ?>
<div class="page-wrap">
    <?
    $class = new managersClass();
    $manager_groups = CUser::GetUserGroup(CUser::GetID());
    $manager_code = $class->get_manager_code($manager_groups);
    if(CSite::InDir("/managers/") && $APPLICATION->GetCurDir() != "/managers/" && !$manager_code) {
        LocalRedirect("/");
    }
    ?>

