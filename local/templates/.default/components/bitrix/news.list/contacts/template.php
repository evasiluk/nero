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
use \Bitrix\Main\Localization\Loc;
?>


<div class="js-contact-app">

    <div class="content-title-block">

        <img src="<?= DEFAULT_ASSETS_PATH ?>/userimg/contact-1.jpg" alt="">

        <div class="bc-txt-wrap">

            <div class="backnav backnav--white">
                <ul>
                    <li><a href="#">Nero</a></li>
                    <li><a href="#"><?= Loc::getMessage('contacts'); ?></a></li>
                </ul>
            </div>

            <div class="usercontent js-bc-top">

                <h1><?= Loc::getMessage('contacts'); ?></h1>

                <div class="bc-txt-details flex-row top-xs">
                    <div class="col-xs col">
                        <?if(SITE_ID == "s2"):?>
                        <?
                        $regions_lang = array(
                            "Беларусь" => "Belarus",
                            "Украина" => "Ukraine",
                            "Россия (Москва)" => "Russia (Moscow)",
                            "Россия (Санкт-Петербург)" => "Russia (Saint-Petersburg)",
                        );
                        ?>
                        <?endif?>
                        <div class="bc-select">
                            <select class="js-redirect_on_change" data-select>
                                <?foreach ($arResult['ITEMS_BY_REGION'] as $region){?>
                                    <option<?if($region['SELECTED']) echo ' selected'?> value="<?=$region['LINK'];?>" href="<?=$region['LINK'];?>">
                                        <?if(SITE_ID == "s2"):?>
                                            <?=$regions_lang[$region['REGION']->getField('NAME')]?>
                                        <?else:?>
                                            <?=$region['REGION']->getField('NAME')?>
                                        <?endif?>
                                    </option>
                                <?}?>
                            </select>
                        </div>

                        <h2><?= $arResult['MAIN']['NAME'] ?></h2>
                        <p><?= $arResult['MAIN']['PREVIEW_TEXT'] ?></p>
                        <a href="#" class="ico-link link-small">
                            <svg class="ico-placemark" viewBox="0 0 300 300">
                                <use xlink:href="#ico-placemark"></use>
                            </svg>
                            <span><?= Loc::getMessage('how_to_ride'); ?></span>
                        </a>
                    </div>
                    <div class="col-xs col">
                        <div class="list-ico-links">
                            <? foreach ($arResult['MAIN']['PROPERTIES']['phone']['VALUE'] as $key => $phone) {
                                $icon = '#ico-' . ($arResult['MAIN']['PROPERTIES']['phone']['DESCRIPTION'][$key] ?: 'phone'); ?>
                                <p>
                                    <a href="tel:<?= $phone ?>" class="ico-link link-shift">
                                        <svg class="ico-24" viewBox="0 0 505.8 493.9">
                                            <use xlink:href="<?= $icon ?>"></use>
                                        </svg>
                                        <span><?= $phone ?></span>
                                    </a>
                                </p>
                            <? } ?>
                            <? foreach ($arResult['MAIN']['PROPERTIES']['email']['VALUE'] as $key => $email) { ?>
                                <p>
                                    <a href="mailto:<?= $email ?>" class="ico-link link-shift">
                                        <svg class="ico-24" viewBox="0 0 505.8 493.9">
                                            <use xlink:href="#ico-mail"></use>
                                        </svg>
                                        <span><?= $email ?></span>
                                    </a>
                                </p>
                            <? } ?>
                        </div>

                        <?= $arResult['MAIN']['DETAIL_TEXT'] ?>
                    </div>
                </div>
            </div>

            <h3 class="bc-txt-show js-bc-view-toggle"><a href="#"><?= Loc::getMessage('back_to_contacts'); ?></a></h3>

        </div>

        <div class="bc-map-wrap">

            <div class="bc-map" id="contact_map"></div>

            <h3 class="bc-map-show js-bc-view-toggle"><a href="#"><?= Loc::getMessage('show_map'); ?></a></h3>

        </div>

        <script>
            var ctPos = [53.807228, 27.692027];
        </script>

        <div class="godown js-goto" data-goto="#screen-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path d="M256 298.3l174.2-167.2c4.3-4.2 11.4-4.1 15.8.2l30.6 29.9c4.4 4.3 4.5 11.3.2 15.5L264.1 380.9c-2.2 2.2-5.2 3.2-8.1 3-3 .1-5.9-.9-8.1-3L35.2 176.7c-4.3-4.2-4.2-11.2.2-15.5L66 131.3c4.4-4.3 11.5-4.4 15.8-.2L256 298.3z"/>
            </svg>
        </div>

    </div>

    <script id="card-map" type="text/x-jquery-tmpl">
        <!-- cardDirectionsIframe -->
    </script>

    <div class="wrap" id="screen-2">
        <div class="cards flex-row">

            <? foreach ($arResult['ITEMS_BY_REGION'] as $region) { ?>
                <? foreach ($region['ITEMS'] as $arItem) { ?>
                    <div class="col-xs-12 col-sm-6">
                        <div class="card">
                            <div class="card-title"><?= $arItem['NAME'] ?></div>

                            <? if ($arItem['PROPERTIES']['organization']['VALUE']) { ?>
                                <p class="card-name"><?= $arItem['PROPERTIES']['organization']['VALUE'] ?></p>
                            <? } ?>

                            <p><?= $arItem['PREVIEW_TEXT'] ?></p>

                            <? if ($arItem['PROPERTIES']['coordinates']['VALUE']) { ?>
                                <div class="card-location">
                                    <p>
                                        <a href="#card-map" data-pos="<?= $arItem['PROPERTIES']['coordinates']['VALUE'] ?>" class="ico-link link-small is-hidden js-card-route-open">
                                            <svg class="ico-placemark" viewBox="0 0 300 300">
                                                <use xlink:href="#ico-placemark"></use>
                                            </svg>
                                            <span>Как проехать</span>
                                        </a>
                                        <a href="#card-map" data-pos="<?= $arItem['PROPERTIES']['coordinates']['VALUE'] ?>" class="ico-link link-small js-card-map-open">
                                            <svg class="ico-placemark" viewBox="0 0 300 300">
                                                <use xlink:href="#ico-placemark"></use>
                                            </svg>
                                            <span>На карте</span>
                                        </a>
                                    </p>
                                </div>
                            <? } ?>

                            <div class="card-contacts">
                                <? foreach ($arItem['PROPERTIES']['phone']['VALUE'] as $key => $phone) { ?>
                                    <?= Loc::getMessage('phone'); ?> <b><?= $phone ?></b><br>
                                <? } ?>

                                <? foreach ($arItem['PROPERTIES']['email']['VALUE'] as $key => $email) { ?>
                                    <?= Loc::getMessage('email'); ?> <a href="mailto:<?= $email ?>"><?= $email ?></a><br>
                                <? } ?>

                                <? if ($arItem['PROPERTIES']['worktime']['VALUE']) { ?>
                                    <br><b><?= Loc::getMessage('time'); ?></b> <?= $arItem['PROPERTIES']['worktime']['VALUE'] ?>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                <? } ?>
            <? } ?>
        </div>
    </div>

</div>

<div class="cu-form-wrap">
    <form action="./contact-form.php" class="cu-form js-cu-form">

        <div class="form-row flex-row form-header">
            <div class="col-xs center-xs">
                <?= Loc::getMessage('feedback'); ?>
            </div>
        </div>

        <div class="form-row flex-row">
            <div class="col-xs">
                <select name="category" id="" data-select>
                    <option placeholder><?= Loc::getMessage('select_cat'); ?></option>
                    <option value="Запрос"><?= Loc::getMessage('request'); ?></option>
                    <option value="Предложение"><?= Loc::getMessage('proposal'); ?></option>
                    <option value="Жалоба"><?= Loc::getMessage('complain'); ?></option>
                </select>
            </div>
        </div>

        <div class="form-row flex-row">
            <div class="col-xs">
                <input type="text" placeholder="<?= Loc::getMessage('form_name'); ?>" name="name">
            </div>
        </div>

        <div class="form-row flex-row">
            <div class="col-xs">
                <input type="text" placeholder="<?= Loc::getMessage('form_phone'); ?>" name="phone" required>
                <div class="input-required-tip">*</div>
            </div>
            <div class="col-xs">
                <input type="email" placeholder="Email" name="email" required>
                <div class="input-required-tip">*</div>
            </div>
        </div>

        <div class="form-row flex-row">
            <div class="col-xs">
                <textarea placeholder="<?= Loc::getMessage('message'); ?>" name="message"></textarea>
            </div>
        </div>

        <div class="form-row flex-row flex-row-padding form-footer">
            <div class="col-xs-12 center-xs">
                <a href="#"
                   class="js-cu-form-submit button button--big button--white button-hover--bgblack"><?= Loc::getMessage('form_send'); ?></a>
            </div>
            <div class="col-xs-12 center-xs">
                <div class="tip color--white">* <?= Loc::getMessage('form_required'); ?></div>
            </div>
        </div>

    </form>

    <div class="cu-form-success">
        <?= Loc::getMessage('form_success'); ?>
    </div>
</div>