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

use \Bitrix\Main\Localization\Loc;

?>

<div class="b-subscribe js-subscribe">

    <div class="subscribe-header js-subscribe-header"><?= Loc::getMessage('subscr_form_email_title'); ?></div>
    <form action="<?= $arResult["FORM_ACTION"] ?>" class="subscribe-form js-subscribe-form">
        <? foreach ($arResult["RUBRICS"] as $itemID => $itemValue): ?>
            <input type="hidden" name="rubrics[]" id="rubrics<?= $itemValue["ID"] ?>" value="<?= $itemValue["ID"] ?>"/>
        <? endforeach; ?>

        <button type="submit" name="OK" value="<?= Loc::getMessage('subscr_form_button'); ?>" class="button button--bgred hide-640"><?= Loc::getMessage('subscr_form_button'); ?></button>

        <div class="subscribe-wrap">
            <input type="email" name="email" class="subscribe-input" placeholder="<?= Loc::getMessage('subscr_form_email'); ?>" required>
        </div>

        <button type="submit" name="OK" value="<?= Loc::getMessage('subscr_form_button_small'); ?>" class="button button--bgred show-640">
        <!-- <?= Loc::getMessage('subscr_form_button_small'); ?> -->
        	Ok
        </button>
    </form>

    <div class="subscribe-result js-subscribe-success">
        <!-- success data here -->
    </div>

    <div class="subscribe-result js-subscribe-error">
        <!-- error data here -->
    </div>

</div>