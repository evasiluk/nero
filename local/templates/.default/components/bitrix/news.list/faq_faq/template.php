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
$uri = new \Bitrix\Main\Web\Uri('/local/ajax/faq_like.php');
?>

<div class="wrap">
    <div class="l-faq standalone">
        <? foreach ($arResult["ITEMS"] as $arItem) {
            $uri->addParams(['id' => $arItem['ID']]);?>
            <div id="question<?=$arItem['ID']?>">
                <a href="#" class="faq-q"><span><?= $arItem['NAME'] ?></span></a>
                <div class="faq-a">
                    <p><?= $arItem['PREVIEW_TEXT'] ?></p>
                    <div class="faq-footer js-faq__is_usefull">
                        <span>Полезный ответ?</span>
                        <a href="<?=$uri->addParams(['action' => $helper::ACTION_PLUS])->getUri()?>"
                            <?if($helper->getUserLastVote($arItem['ID']) == $helper::ACTION_PLUS) echo "class='active'";?>
                        >
                            Да
                        </a>
                        <a href="<?=$uri->addParams(['action' => $helper::ACTION_MINUS])->getUri()?>"
                            <?if($helper->getUserLastVote($arItem['ID']) == $helper::ACTION_MINUS) echo "class='active'";?>
                        >
                            Нет
                        </a>
                        <a href="#" class="button js-goto" data-goto="#form_faq" data-shift="true">Задать вопрос</a>
                    </div>
                </div>
            </div>
        <? } ?>
    </div>
</div>
