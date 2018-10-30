<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>

<section class="wrap form-wrap form-wrap-bgtransparent">
    <div class="usercontent form-loading js-form-loading">
        <h4 class="align-center">Загрузка…</h4>
    </div>

    <?if($arResult['QUANTITY_ALL']):?>
        <div class="usercontent">
            <form class="form form-wide form-checkout js-checkout" method="post" action="/local/ajax/makeOrder.php">
            <div id="res" style="display: none">
                <div class="form-checkout-section">
                    <div class="form-checkout-header">
                        <div class="flex-row flex-row-padding">
                            <h3></h3>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="make_order" value="<?=uniqid()?>">
            <input type="hidden" name="portal" value="<?=$arResult["PORTAL_CODE"]?>" id="pcode">
            <input type="hidden" name="deal" value="<?=$arResult["IS_DEALER"]?>" id="isdeal">
            <div class="form-step">
            <div class="form-checkout-section">
                <div class="form-checkout-header">
                    <div class="flex-row flex-row-padding">
                        <div class="col-xs-12 col-md"><h3>Контактные данные</h3></div>
                        <div class="col-xs-12 col-md end-md start-xs">
                            <?if(!$arResult["USER_LOGIN"]):?>
                                <span><a href="/content/personal/auth/">Войдите</a>, если ранее регистрировались или делали покупки.</span>
                            <?endif?>
                        </div>
                    </div>
                </div>

                <div class="form-row flex-row flex-row-padding">
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <label class="input">
                            <span class="input-label">Имя<sup>*</sup></span>
                            <div class="input-in">
                                <input type="text" name="user[name]" value="<?echo $arResult["USER"]["NAME"]? $arResult["USER"]["NAME"] : ""?>" required/>
                            </div>
                        </label>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <label class="input">
                            <span class="input-label">Телефон<sup>*</sup></span>
                            <div class="input-in">
                                <input type="tel" name="user[phone]" value="<?echo $arResult["USER"]["PHONE"]? $arResult["USER"]["PHONE"] : ""?>" required data-parsley-pattern="^[\d\+\-\.\(\)\/\s]*$"/>
                            </div>
                        </label>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <label class="input">
                            <span class="input-label">E-mail<sup>*</sup></span>
                            <div class="input-in">
                                <input type="email" name="user[email]" value="<?echo $arResult["USER"]["EMAIL"]? $arResult["USER"]["EMAIL"] : ""?>" required />
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-checkout-section" id="delivery_type">
                <div class="form-checkout-header">
                    <div class="flex-row flex-row-padding">
                        <div class="col-xs-12 col-md">
                            <h3>Доставка</h3>
                        </div>
                    </div>
                </div>

                <div>
                    <?
                    CJSCore::Init(array("ajax"));

                    ?>
                    <?$APPLICATION->IncludeComponent("bitrix:sale.location.selector.search", "nero_location_search", Array(
                            "CACHE_TIME" => "3",	// Время кеширования (сек.)
                            "CACHE_TYPE" => "A",	// Тип кеширования
                            "CODE" => "",	// Символьный код местоположения
                            "FILTER_BY_SITE" => "N",	// Фильтровать по сайту
                            "ID" => $arResult["LOCATION"],	// ID местоположения
                            "INITIALIZE_BY_GLOBAL_EVENT" => "",	// Инициализировать компонент только при наступлении указанного javascript-события на объекте window.document
                            "INPUT_NAME" => "LOCATION",	// Имя поля ввода
                            "JS_CALLBACK" => "",	// Javascript-функция обратного вызова
                            "JS_CONTROL_GLOBAL_ID" => "",	// Идентификатор javascript-контрола
                            "PROVIDE_LINK_BY" => "id",	// Сохранять связь через
                            "SHOW_DEFAULT_LOCATIONS" => "N",	// Отображать местоположения по-умолчанию
                            "SUPPRESS_ERRORS" => "N",	// Не показывать ошибки, если они возникли при загрузке компонента
                        ),
                        false
                    );?>
                </div>


                <div class="radio-block js-delivery">
                    <div class="flex-row" style="">
                        <div class="col-xs-12 col-md-6">
                            <label>
                                <input data-price="0" data-title="самовывоз" type="radio" name="delivery[]" value="5" required checked class="js-delivery-radio">
                                <span>Самовывоз из представительства компании Nero Electronics</span>
                            </label>

                            <div class="radio-block-descr">
                                <?if($arResult["SHOWROOM"]):?>
                                    <div class="radio-block-adress js-delivery-details" style="display: block;">
                                        <?if($arResult["SHOWROOM"]["ADRESS"]):?>
                                            <p>
                                                <b>Адрес:</b><br/>
                                                <?=$arResult["SHOWROOM"]["ADRESS"]?>
                                            </p>
                                        <?endif?>
                                        <?if($arResult["SHOWROOM"]["PHONE"]):?>
                                            <p>
                                                <b>Телефон:</b><br/>
                                                <?foreach($arResult["SHOWROOM"]["PHONE"] as $i => $phone):?>
                                                    <?if($i > 0):?>
                                                        <br>
                                                    <?endif?>
                                                <?=$phone?>
                                                <?endforeach?>
                                            </p>
                                        <?endif?>
                                        <?if($arResult["SHOWROOM"]["WORKTIME"]):?>
                                            <p>
                                                <b>Время работы:</b><br/>
                                                <?=$arResult["SHOWROOM"]["WORKTIME"]?>
                                            </p>
                                        <?endif?>

                                    </div>
                                <?endif?>


                                <p>Вы можете самостоятельно забрать свой заказ в офисе представительства. Дождитесь уведомления, что заказ готов, и приезжайте в удобное для Вас время. Срок доставки: от 2 до 7 дней.</p>
                            </div>
                        </div>
                        <?if($arResult["SHOWROOM"]["COORD"]):?>
                            <div class="col-xs-12 col-md-5 col-md-offset-1 js-delivery-details" style="display: block;">
                                <iframe width="100%" height="40vh" frameborder="0" style="border:0; min-height: 250px; max-height: 400px;" src="https://www.google.com/maps/embed/v1/place?q=<?=$arResult["SHOWROOM"]["COORD"]?>&key=AIzaSyBQL00FgROUCp6WZvnPdEdiyhE3f49hYew" allowfullscreen></iframe>
                            </div>
                        <?endif?>
                        
                    </div>
                </div>

                <?if($arResult["DELIVERY"]["COURIER"]):?>
                    <?foreach($arResult["DELIVERY"]["COURIER"] as $courier):?>
                        <div class="radio-block js-delivery">
                            <div class="flex-row" style="">
                                <div class="col-xs-12 col-md-8">
                                    <label>
                                        <input data-price="<?=$courier["PRICE"]?>" data-title="курьером" type="radio" name="delivery[]" value="<?=$courier["ID"]?>"  class="js-delivery-radio">
                                        <span><?=$courier["DESCRIPTION"]?>:</span>
                                    </label>
                                    <div class="radio-block-descr">
                                        <ul>
<!--                                            <li>стоимость доставки: --><?//=$courier["PRICE"]? $courier["PRICE"]." ".$arResult["VALUTE_SHORT"] : "бесплатно"?><!--</li>-->
                                            <li>курьер доставит заказ по указанному Вами адресу. Срок доставки: от 2 до 8 дней</li>
                                            <?if($courier["NOTICE"]):?>
                                                <li><?=$courier["NOTICE"]?></li>
                                            <?endif?>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row flex-row flex-row-padding js-delivery-details" style="display: none;">
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <?//print_pre($courier["LOCATIONS"])?>
                                    <label class="input">
                                        <span class="input-label">Населенный пункт<sup>*</sup></span>
                                        <div class="input-in">
                                            <input disabled type="text" name="kur[city]" value="<?=$arResult["LOCATION_PATH"]?>"/>
                                        </div>
                                    </label>
                                    <br>
                                    <p>Cтоимость доставки: <?=$courier["PRICE"]? $courier["PRICE"]." ".$arResult["VALUTE_SHORT"] : "бесплатно"?></p>

                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <label class="input">
                                        <span class="input-label">Улица<sup>*</sup></span>
                                        <div class="input-in">
                                            <input type="text" name="kur[street]" value="" required data-parsley-group="kur"/>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <div class="form-row flex-row form-row-nopadd">
                                        <label class="col-xs input">
                                            <span class="input-label">Дом<sup>*</sup></span>
                                            <div class="input-in">
                                                <input type="text" name="kur[house]" value="" required data-parsley-group="kur"/>
                                            </div>
                                        </label>
                                        <label class="col-xs input">
                                            <span class="input-label">Корпус</span>
                                            <div class="input-in">
                                                <input type="text" name="kur[house-2]" value=""/>
                                            </div>
                                        </label>
                                        <label class="col-xs input">
                                            <span class="input-label">Квартира</span>
                                            <div class="input-in">
                                                <input type="text" name="kur[kv]" value=""/>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?endforeach?>

                <?endif?>



                <?if($arResult["DELIVERY"]["CARGO"]):?>
                    <div class="radio-block js-delivery">
                        <div class="flex-row">
                            <div class="col-xs-12 col-md-8">
                                <label>
                                    <input data-price="<?=$arResult["DELIVERY"]["CARGO"]["PRICE"]?>" data-title="грузоперевозчиком" type="radio" name="delivery[]" value="<?=$arResult["DELIVERY"]["CARGO"]["ID"]?>" class="js-delivery-radio">
                                    <span><?=$arResult["DELIVERY"]["CARGO"]["DESCRIPTION"]?>:</span>
                                </label>
                                <div class="radio-block-descr">
                                    <ul>
                                        <li>Ваш заказ будет доставлен грузоперевозчиком в течение 2-8 дней.</li>
                                        <li>Стоимость доставки зависит от пункта назначения и веса отправления.</li>
<!--                                        <li>стоимость доставки: --><?//=$arResult["DELIVERY"]["CARGO"]["PRICE"]? $arResult["DELIVERY"]["CARGO"]["PRICE"]." ".$arResult["VALUTE_SHORT"] : "бесплатно"?><!--</li>-->
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="form-row flex-row flex-row-padding js-delivery-details" style="display: none;">
                            <div class="col-xs-12 col-sm-6 col-md-4">

                                    <label class="input">
                                        <span class="input-label">Населенный пункт<sup>*</sup></span>
                                        <div class="input-in">
                                            <input disabled type="text" name="gruz[city]" value="<?=$arResult["LOCATION_PATH"]?>"/>
                                        </div>
                                    </label>
                                <br>
                                <p>Cтоимость доставки: <?=$arResult["DELIVERY"]["CARGO"]["PRICE"]? $arResult["DELIVERY"]["CARGO"]["PRICE"]." ".$arResult["VALUTE_SHORT"] : "бесплатно"?></p>

                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <label class="input">
                                    <span class="input-label">Улица<sup>*</sup></span>
                                    <div class="input-in">
                                        <input type="text" name="gruz[street]" value="" required data-parsley-group="gruz"/>
                                    </div>
                                </label>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="form-row flex-row form-row-nopadd">
                                    <label class="col-xs input">
                                        <span class="input-label">Дом<sup>*</sup></span>
                                        <div class="input-in">
                                            <input type="text" name="gruz[house]" value="" required data-parsley-group="gruz"/>
                                        </div>
                                    </label>
                                    <label class="col-xs input">
                                        <span class="input-label">Корпус</span>
                                        <div class="input-in">
                                            <input type="text" name="gruz[house-2]" value=""/>
                                        </div>
                                    </label>
                                    <label class="col-xs input">
                                        <span class="input-label">Квартира</span>
                                        <div class="input-in">
                                            <input type="text" name="gruz[kv]" value=""/>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                <?endif?>


            </div>

            <div class="form-checkout-section" id="payment_type">
                <div class="form-checkout-header">
                    <div class="flex-row flex-row-padding">
                        <div class="col-xs-12 col-md">
                            <h3>Способ оплаты</h3>
                        </div>
                    </div>
                </div>

                <div class="radio-block">
                    <div class="flex-row" style="">
                        <div class="col-xs-12 col-md-8">
                            <label>
                                <input data-title="наличными" type="radio" name="payment[]" value="1" checked required>
                                <span>Наличными</span>
                                <div class="radio-block-descr">Оплата принимается в момент получения товара.</div>
                            </label>
                        </div>
                    </div>
                </div>
                <?if(CURRENT_USER_HOST == BY_HOST):?>
                    <div class="radio-block">
                        <div class="flex-row" style="">
                            <div class="col-xs-12 col-md-8">
                                <label>
                                    <input data-title="банковской картой курьеру/менеджеру" type="radio" name="payment[]" value="2">
                                    <span>Банковской картой курьеру/менеджеру</span>
                                    <div class="radio-block-descr">Оплата принимается в момент получения товара.</div>
                                </label>
                            </div>
                        </div>
                    </div>
                <?endif?>

            </div>

            <div class="form-checkout-footer">
                <div class="flex-row flex-row-padding">
                    <div class="col-xs-12 col-md-6">
                        <div id="result-ajax-left">
                            <div class="dot-row">
                                <div class="dot-col">Итого <?=$arResult["QUANTITY_ALL"]?> товар(-ов)</div>
                                <div class="dot-col">
                                    <div class="product-price product-price-small">
                                        <span id="items_price"><?=$arResult["PRICE_ALL_REGION"]?></span>
                                        <sup><?=$arResult["VALUTE_SHORT"]?></sup>
                                    </div>
                                </div>
                            </div>

                            <div class="dot-row">
                                <div class="dot-col">Моя скидка</div>
                                <div class="dot-col">
                                    <div class="product-price product-price-small">
                                        <?if($arResult["DISCOUNT_PRICE_ALL_REGION"]):?>
                                            <span id="discount"><?=$arResult["DISCOUNT_PRICE_ALL_REGION"]?></span>
                                            <sup><?=$arResult["VALUTE_SHORT"]?></sup>
                                        <?else:?>
                                            <span>без скидки</span>
                                        <?endif?>

                                    </div>
                                </div>
                            </div>

                            <div class="dot-row">
                                <div class="dot-col">Доставка</div>
                                <div class="dot-col">
                                    <div class="product-price product-price-small">
                                        <span id="result_delivery_name">самовывоз</span>
                                    </div>
                                </div>
                            </div>

                            <div class="dot-row">
                                <div class="dot-col">Стоимость доставки</div>
                                <div class="dot-col">
                                    <div class="product-price product-price-small">
                                        <span id="result_delivery_price">бесплатно</span>
                                        <sup id="result_delivery_valute" style="display: none"><?=$arResult["VALUTE_SHORT"]?></sup>
                                    </div>
                                </div>
                            </div>

                            <div class="dot-row">
                                <div class="dot-col">Оплата</div>
                                <div class="dot-col">
                                    <div class="product-price product-price-small">
                                        <span id="result_payment_name">наличными</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div id="result-ajax-right">

                            <div class="dot-row">
                                <div class="dot-col"><h3>Итого к оплате</h3></div>
                                <div class="dot-col dot-col-auto">
                                    <div class="product-price">
                                        <span id="final_price"><?=$arResult['PRICE_ALL_REGION_FINAL']?></span>
                                        <sup><?=$arResult["VALUTE_SHORT"]?></sup>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <label class="input">
                                    <span class="input-label">Комментарий</span>
                                    <div class="input-in">
                                        <textarea name="user_comment"></textarea>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="form-agreement-box">
                            <p>
                                <label>
                                    <input type="checkbox" name="agreement[]" required />
                                    <span>Я даю согласие на обработку персональных данных.</span>
                                </label>
                            </p>
                        </div>

                        <input type="submit" class="button button--bgred button--big" value="Оформить">
                    </div>
                </div>
            </div>
            </div>
            </form>
        </div>
    <?else:?>
        <div class="usercontent bg--white basket-is-empty js-basket-is-empty">
            <div class="wrap wrap-content">
                <h2 class="align-center">Корзина пуста</h2>
            </div>
        </div>
    <?endif?>
</section>














