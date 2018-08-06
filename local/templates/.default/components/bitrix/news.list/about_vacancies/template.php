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

<div class="wrap">
    <h2 class="align-center"><?= Loc::getMessage('active_vacancies'); ?></h2>

    <div class="filter filter-vacancy">

        <div class="filter-row">

            <div class="filter-wrap">

                <? foreach ($arResult["filters"] as $key => $filter) { ?>
                    <div class="filter-node">
                        <label class="filter-label"><?=$filter['name']?>:</label>
                        <div class="filter-ctrl">
                            <select name="<?=$key?>" data-select>
                                <option value="">Все</option>
                                <? foreach ($filter["values"] as $k => $option) { ?>
                                    <option value="<?=$k?>"><?=$option?></option>
                                <?}?>
                            </select>
                        </div>
                    </div>
                <?}?>

            </div>

        </div>

    </div>

    <div class="l-vacancy">
        <div class="flex-row">
            <? foreach ($arResult["ITEMS"] as $arItem) { ?>
                <div class="col-xs-12 col-sm-12 col-md-6" <?=$arItem['filter_data_string']?>>

                    <a href="#vacancy<?= $arItem['ID'] ?>" class="card card-vacancy js-popup-open">
                        <? if ($arItem['PROPERTIES']['team']['VALUE']) { ?>
                            <div class="vacancy-type"><?= $arItem['PROPERTIES']['team']['VALUE'] ?></div>
                        <? } ?>
                        <div class="vacancy-position">
                            <span data-popup-title=""><?= $arItem['NAME'] ?></span>
                        </div>
                        <p><?= $arItem['PREVIEW_TEXT'] ?></p>
                        <? if ($arItem['PROPERTIES']['location']['VALUE']) { ?>
                            <div class="vacancy-place">
                                <svg viewBox="0 0 300 300">
                                    <use xlink:href="#ico-placemark"></use>
                                </svg>
                                <span><?= $arItem['PROPERTIES']['location']['VALUE'] ?></span>
                            </div>
                        <? } ?>
                        <span class="arrow arrow--right"></span>
                    </a>

                    <script type="x-template" id="vacancy<?= $arItem['ID'] ?>">
                        <div class="usercontent vacancy-popup-content">
                            <div class="popup-content-head">
                                <h2 class="align-center"><?= Loc::getMessage('marketing_division'); ?></h2>
                            </div>

                            <?=$arItem['DETAIL_TEXT']?>


                            <div class="ovh-box">
                                <div class="flex-row flex-row-padding flex-row-inline middle-xs">
                                    <div class="col-xs col-xs-aside">
                                        <a href="#" class="button button--bgred"><?= Loc::getMessage('become_emploee'); ?></a>
                                    </div>
                                    <div class="col-xs">
                                        <a href="#" class="ico-link">
                                            <svg class="ico-24" viewBox="0 0 16 16">
                                                <use xlink:href="#ico-attachement"></use>
                                            </svg>
                                            <span><?= Loc::getMessage('download_app'); ?></span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <h4 class="align-center"><?= Loc::getMessage('vac_contacts'); ?>:</h4>

                            <?\Astronim\Helper::includeFile('about/vacancies_hr_popup', ['mode'=>'text', 'name' => 'Вакансии в попапе']);?>

                        </div>
                    </script>

                </div>
            <? } ?>

            <div class="col-xs-12 l-vacancy-footer">
                <div class="ovh">
                    <div class="flex-row flex-row-padding flex-row-inline middle-xs">
                        <div class="col-xs-12 col-sm col-xs-aside">
                            <a href="/content/about/vacancies/stat-sotrudnikom-kompanii/" class="button button--bgred">
                                <?= Loc::getMessage('become_emploee_2_1'); ?> <span class="hide-640"><?= Loc::getMessage('become_emploee_2_2'); ?></span>
                            </a>
                        </div>
                        <div class="col-xs-12 col-sm">
                            <?\Astronim\Helper::includeFile('about/vacancies_hr_file', ['mode'=>'text', 'name' => 'Анкета']);?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
