<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
//print_pre($arResult['ORDER']);
?>
<? if ($request->get('print') !== null) { ?>
    <table class="printable">
        <tbody>
        <tr>
            <th colspan="2"><?= $APPLICATION->ShowTitle() ?></th>
        </tr>
        <tr>
            <td>Пользователь:</td>

			<td><?= "{$arResult['USER']['LAST_NAME']} {$arResult['USER']['NAME']} {$arResult['USER']['SECOND_NAME']}, {$arResult['USER']['EMAIL']}, {$arResult['USER']['PERSONAL_PHONE']}  "?> <?= GetCountryByID($arResult['USER']['PERSONAL_COUNTRY'], LANGUAGE_ID)
                                . ($arResult['USER']['PERSONAL_CITY'] ? "  г.{$arResult['USER']['PERSONAL_CITY']}" : '') ?> </td>
        </tr>
        <tr>
            <td>Статус:</td>
            <td><?= $arResult['STATUS'][$arResult['ORDER']['STATUS_ID']]['NAME'] ?></td>
        </tr>
        <tr>
            <td>Создан:</td>
            <td><?= $arResult['ORDER']['DATE_INSERT'] ?></td>
        </tr>

        <tr>
            <th colspan="2">Свойства заказа</th>
        </tr>
        <? foreach (\Astronim\PaidService\Controller::getFormFields($arResult['ITEM']) as $key => $prop) {
		  $default ='';
          if ($prop['CODE'] == $arResult['ITEM']::PRICE_BASKET_CODE) {
              $arResult['BASKET']['PROPS'][$prop['CODE']]['VALUE'] = $arResult['ITEM']->getPrice($arResult['BASKET']['PROPS'][$prop['CODE']]['VALUE'])['VALUE'];

        }

            $name = ($arResult['ITEM']->getLangProperty($prop['CODE']) ?: $prop['NAME']);

            if ($arResult['ITEM']->properties[$prop['CODE']]['PROPERTY_TYPE'] == 'L') {

                            foreach ($arResult['ITEM']->properties[$prop['CODE']]['VALUES'] as $arListValue => $MassiveProps){
								foreach ($MassiveProps as $MassiveValue => $ElementValue){
                                	if(strpos($arResult['BASKET']['PROPS'][$prop['CODE']]['VALUE'],$MassiveProps['XML_ID'])!==false){
										$default = $default.$MassiveProps['VALUE'].', ';
                                    	break;
                                	}
                            	}
								$value = substr($default, 0, -2);
                        	} 
			}
	else {
            $value = $arResult['BASKET']['PROPS'][$prop['CODE']]['VALUE'];
	}
            if (!$name) {
                continue;
            } ?>
            <tr>
                <td><?= $name ?>:</td>
                <td><?= $value ?></td>
            </tr>
            <?
        } ?>

        <tr>
            <th colspan="2">Стоимость и статус заказа</th>
        </tr>
        <tr>
            <td>Стоимость:</td>
            <td><?= $arResult['ORDER']['PRICE'] ?> <?= $arResult['ORDER']['CURRENCY'] ?></td>
        </tr>
        <tr>
            <td>Статус заказа:</td>
            <td>
                <? foreach ($arResult['STATUS_LIST'] as $arStatus):
                    $selected = ($arResult['ORDER']['STATUS_ID'] == $arStatus['ID']); ?>
                    <?= ($selected ? $arStatus['NAME'] : ""); ?>
                <? endforeach; ?></td>
        </tr>
        <!--        <tr>-->
        <!--            <td>Заказ оплачен:</td>-->
        <!--            <td>--><? //= ($arResult['ORDER']['PAYED'] == 'Y' ? 'Да' : 'Нет') ?><!--</td>-->
        <!--        </tr>-->
        <!--        <tr>-->
        <!--            <td>Заказ отменён:</td>-->
        <!--            <td>--><? //= ($arResult['ORDER']['CANCELED'] == 'Y' ? 'Да' : 'Нет') ?><!--</td>-->
        <!--        </tr>-->
        <? if ($arResult['ORDER']['CANCELED'] == 'Y') { ?>
            <tr>
                <td>Причина отмены:</td>
                <td><?= $arResult['ORDER']['REASON_CANCELED'] ?></td>
            </tr>
        <? } ?>
        </tbody>
    </table>
<? } elseif ($arResult['ORDER']['ID']) { ?>
    <div class="admin-order-detail">
        <div class="admin-order-item">

            <div class="flex-row item-props" style="margin-bottom: 4rem;">
                <div class="col-xs-12 col-sm-6">
                    <div class="item-prop flex-row">
                        <div class="key col-xs-12 col-sm-6"><?= GetMessage("USER") ?></div>
                        <div class="value  col-xs-12 col-sm-6"><?= "{$arResult['USER']['LAST_NAME']} {$arResult['USER']['NAME']} {$arResult['USER']['SECOND_NAME']}" ?></div>
                    </div>
                    <div class="item-prop flex-row">
                        <div class="key col-xs-12 col-sm-6">E-mail:</div>
                        <div class="value  col-xs-12 col-sm-6"><?= "{$arResult['USER']['EMAIL']}" ?></div>
                    </div>
                    <? if ($arResult['USER']['PERSONAL_PHONE']) { ?>
                        <div class="item-prop flex-row">
                            <div class="key col-xs-12 col-sm-6">Телефон:</div>
                            <div class="value  col-xs-12 col-sm-6"><?= "{$arResult['USER']['PERSONAL_PHONE']}" ?></div>
                        </div>
                    <? } ?>
                    <? if ($arResult['USER']['PERSONAL_COUNTRY'] || $arResult['USER']['PERSONAL_CITY']) { ?>
                        <div class="item-prop flex-row">
                            <div class="key col-xs-12 col-sm-6">Локация:</div>
                            <div class="value  col-xs-12 col-sm-6">
                                <?= GetCountryByID($arResult['USER']['PERSONAL_COUNTRY'], LANGUAGE_ID)
                                . ($arResult['USER']['PERSONAL_CITY'] ? "г. {$arResult['USER']['PERSONAL_CITY']}" : '') ?>
                            </div>
                        </div>
                    <? } ?>
                    <!--                    <div class="item-prop flex-row">-->
                    <!--                        <div class="key col-xs-12 col-sm-6">Мобильный телефон:</div>-->
                    <!--                        <div class="value  col-xs-12 col-sm-6">-->
                    <? //= "{$arResult['USER']['MOBILE_PHONE']}" ?><!--</div>-->
                    <!--                    </div>-->

                    <div class="item-prop flex-row">
                        <div class="key col-xs-12 col-sm-6">Статус:</div>
                        <div class="value  col-xs-12 col-sm-6"><?= $arResult['STATUS'][$arResult['ORDER']['STATUS_ID']]['NAME'] ?></div>
                    </div>

                    <div class="item-prop flex-row">
                        <div class="key col-xs-12 col-sm-6">Создан:</div>
                        <div class="value  col-xs-12 col-sm-6"><?= $arResult['ORDER']['DATE_INSERT'] ?></div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 end-xs">
                    <a href="<?= $arResult['PRINT_URL'] ?>" target="_blank" class="button">Печать</a>
                </div>
            </div>

            <div class="item-properties">
                <form method="post" action="<?= $arResult['ACTION_URL'] ?>" class="context-search form-multiple"
                      enctype="multipart/form-data">

                    <!-- service props -->
                    <div class="js-toggleable toggleable">
                        <div class="header-level-2 js-title"><span>Информация о заказе</span></div>

                        <div class="context-search js-content" style="display: none;">
                            <?
                            \Astronim\PaidService\Controller::printFormFields($arResult['ITEM']);
                            ?>
                        </div>
                    </div>
                    <!-- \service props -->

                    <!-- order props -->
                    <div class="js-toggleable toggleable">
                        <div class="header-level-2 js-title"><span>Стоимость и статус заказа</span></div>

                        <div class="context-search js-content">

                            <div class="flex-row">
                                <div class="col-xs-2">
                                    <label for="price_recount">
                                        <input type="checkbox" id="price_recount" name="price_recount">
                                        <span>Пересчитать</span>
                                    </label>
                                </div>
                                <div class="col-xs-2">
                                    <div class="input">
                                        <input class="effect-16" type="number"
                                               name="<?= $arResult['ITEM']::QUANTITY_BASKET_CODE ?>"
                                               value="<?= $arResult['BASKET']['PROPS'][$arResult['ITEM']::QUANTITY_BASKET_CODE]['VALUE'] ?>">
                                        <label>Количество</label>
                                        <span class="focus-border"></span>
                                        <span class="input__note note__success color--green"></span>
                                    </div>
                                </div>
                                <div class="col-xs-8">
                                    <div class="input select">
                                        <select id="status" name="<?= $arResult['ITEM']::PRICE_BASKET_CODE ?>">
                                            <? foreach ($arResult['ITEM']->getPrices() as $id => $arPrice):
                                                $selected = ($arResult['BASKET']['PROPS'][$arResult['ITEM']::PRICE_BASKET_CODE]['VALUE'] == $id); ?>
                                                <option<?= ($selected ? " selected" : ""); ?>
                                                        value="<?= $id ?>">[<?= $arPrice['VALUE'] ?>
                                                    ] <?= $arPrice['DESCRIPTION'] ?></option>
                                            <? endforeach; ?>
                                        </select>
                                        <label>Цена за единицу</label>
                                        <span class="focus-border"></span>
                                        <span class="input__note note__success color--green"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-row">
                                <div class="col-xs-12">
                                    <div class="input">
                                        <input class="effect-16" type="text"
                                               name="field_PRICE"
                                               value="<?= $arResult['ORDER']['PRICE'] ?>">
                                        <label>Стоимость <?= $arResult['ORDER']['CURRENCY'] ?></label>
                                        <span class="focus-border"></span>
                                        <span class="input__note note__success color--green"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-row">
                                <div class="col-xs-12">
                                    <div class="input">
                                        <div class="input select">
                                            <select id="status" name="field_STATUS_ID">
                                                <? foreach ($arResult['STATUS_LIST'] as $arStatus):
                                                    $selected = ($arResult['ORDER']['STATUS_ID'] == $arStatus['ID']); ?>
                                                    <option<?= ($selected ? " selected" : ""); ?>
                                                            value="<?= $arStatus['ID'] ?>"><?= $arStatus['NAME'] ?></option>
                                                <? endforeach; ?>
                                            </select>
                                            <label>Статус заказа</label>
                                            <span class="focus-border"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--                            <div class="flex-row">-->
                            <!--                                <div class="col-xs-12">-->
                            <!--                                    <label for="field_PAYED">-->
                            <!--                                        <input type="checkbox" id="field_PAYED"-->
                            <!--                                               name="field_PAYED" --><? //= ($arResult['ORDER']['PAYED'] == 'Y' ? 'checked' : '') ?>
                            <!--                                               value="Y">-->
                            <!--                                        <span>Заказ оплачен</span>-->
                            <!--                                    </label>-->
                            <!--                                </div>-->
                            <!--                            </div>-->

                            <!--                            <div class="flex-row">-->
                            <!--                                <div class="col-xs-12">-->
                            <!--                                    <label for="field_CANCELED">-->
                            <!--                                        <input type="checkbox" id="field_CANCELED"-->
                            <!--                                               name="field_CANCELED" --><? //= ($arResult['ORDER']['CANCELED'] == 'Y' ? 'checked' : '') ?>
                            <!--                                               value="Y">-->
                            <!--                                        <span>Заказ отменён</span>-->
                            <!--                                    </label>-->
                            <!--                                </div>-->
                            <!--                            </div>-->

                            <div class="flex-row">
                                <div class="col-xs-12">
                                    <div class="input">
	                            <textarea id="field_REASON_CANCELED"
                                          name="field_REASON_CANCELED"><?= $arResult['ORDER']['REASON_CANCELED'] ?> </textarea>
                                        <label for="field_REASON_CANCELED">Причина отмены</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>
                            </div>
                            <!-- \order props -->

                            <div class="form-row flex-row">
                                <div class="col-xs">
                                    <p>Способ оплаты</p>
                                    <div class="input-group">
                                        <? foreach ($arResult['PAY_SYSTEMS'] as $key => $item) { ?>
                                            <div class="col-xs-12">
                                                <label for="pay_system_<?= $item['ID'] ?>">
                                                    <input id="pay_system_<?= $item['ID'] ?>"
                                                           name="field_PAY_SYSTEM_ID"
                                                           value="<?= $item['ID'] ?>"
                                                           required=""
                                                           type="radio"
                                                        <? if ($item['ID'] == $arResult['ORDER']['PAY_SYSTEM_ID']) echo "checked"; ?>
                                                    />
                                                    <span><?= \Bitrix\Main\Localization\Loc::getMessage("PAY_SYSTEM_{$item['ID']}_NAME") ?></span>
                                                </label>
                                            </div>
                                        <? } ?>
                                    </div>
                                </div>
                            </div>


                            <div class="flex-row">
                                <div class="col-xs-6">
                                    <input type="submit" name="submit" value="Сохранить" class="button"/>
                                </div>
                                <div class="col-xs-6 end-xs">
                                    <a href="#tmpl-delete-confirm" class="button button--outline js-popup-show"
                                       data-width="480">Удалить</a>
                                </div>
                            </div>
                            <div class="flex-row">
                                <div class="col-xs-12">
                                    <a class="button go-back back-to-orders" href="<?= $APPLICATION->GetCurDir() ?>">
                                        &larr; Вернуться к списку
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script id="tmpl-delete-confirm" type="text/x-jquery-tmpl">
        <div class="popup-title header-level-3">Удалить?</div>
        <footer class="login-form__footer">
            <div class="flex-row">
                <div class="col-xs-12 col-sm center-xs start-md">
                    <a href="<?= $arResult['DELETE_URL'] ?>" class="button">Да</a>
                </div>
                <div class="col-xs-12 col-sm center-xs end-md">
                    <a href="#close" class="button button--outline">Нет</a>
                </div>
            </div>
        </footer>



    </script>

    <!--     <div id="delete" class="popup">
        Вы уверены?
        <a href="<?= $arResult['DELETE_URL'] ?>" class="button btn-danger">Да!</a>
        <a href="#close" class="button btn-danger popup-close">Нет...</a>
    </div> -->

<? } elseif ($arResult['DELETED']) { ?>
    <p class="error-text"> Заказ удалён </p>
<? } elseif (isset($arResult['ERROR'])) {
    switch ($arResult['ERROR']) {
        case 'user_unauthorized':
            echo "<p class=\"error-text\">Необходимо авторизоваться!</p>";
            break;
        default:
            echo "<p class=\"error-text\">Произошла непредвиденная ошибка</p>";
            break;
    }
} else { ?>
    <p class="error-text">Заказа не сущестует</p>
<? } ?>