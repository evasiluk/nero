<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>

<section class="wrap form-wrap form-wrap-bgtransparent">
    <div class="usercontent form-loading js-form-loading">
        <h4 class="align-center">Загрузка…</h4>
    </div>

    <div class="usercontent">
        <form class="form form-wide form-checkout js-form">

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
                                    <input type="text" name="user[name]" value="" required/>
                                </div>
                            </label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <label class="input">
                                <span class="input-label">Телефон<sup>*</sup></span>
                                <div class="input-in">
                                    <input type="tel" name="user[phone]" value="" required data-parsley-type="digits"/>
                                </div>
                            </label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <label class="input">
                                <span class="input-label">E-mail<sup>*</sup></span>
                                <div class="input-in">
                                    <input type="email" name="user[email]" value="" required />
                                </div>
                            </label>
                        </div>
                    </div>

                </div>

                <div class="form-checkout-section">
                    <div class="form-checkout-header">
                        <div class="flex-row flex-row-padding">
                            <div class="col-xs-12 col-md">
                                <h3>Доставка</h3>
                            </div>
                        </div>
                    </div>

                    <div class="radio-block">
                        <div class="flex-row" style="">
                            <div class="col-xs-12 col-md-8">
                                <label>
                                    <input type="radio" name="delivery" value="1">
                                    <span>Самовывоз из представительства компании Nero Electronics</span>
                                </label>
                                <div class="radio-block-descr">
                                    <p>Вы можете самостоятельно забрать свой заказ в офисе представительства. Дождитесь уведомления, что заказ готов, и приезжайте в удобное для Вас время. Часы работы офиса указаны на странице <a href="/content/contacts/">«Контакты»</a>. Срок доставки: от 2 до 7 дней.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="radio-block">
                        <div class="flex-row" style="">
                            <div class="col-xs-12 col-md-8">
                                <label>
                                    <input type="radio" name="delivery" value="2">
                                    <span>Доставка курьером по Минску и Минскому району (Москве, Киеву, Санкт-Петербургу):</span>
                                </label>
                                <div class="radio-block-descr">
                                    <ul>
                                        <li>стоимость доставки: 5 рублей</li>
                                        <li>курьер доставит заказ по указанному Вами адресу. Срок доставки: от 2 до 7 дней</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="form-row flex-row flex-row-padding">
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <label class="input">
                                    <span class="input-label">Населенный пункт<sup>*</sup></span>
                                    <div class="input-in">
                                        <input type="text" name="kur[city]" value="Минск, Минская область" disabled="disabled"/>
                                    </div>
                                </label>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <label class="input">
                                    <span class="input-label">Улица<sup>*</sup></span>
                                    <div class="input-in">
                                        <input type="text" name="kur[street]" value=""/>
                                    </div>
                                </label>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="form-row flex-row form-row-nopadd">
                                    <label class="col-xs input">
                                        <span class="input-label">Дом<sup>*</sup></span>
                                        <div class="input-in">
                                            <input type="text" name="kur[house]" value=""/>
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

                    <div class="radio-block">
                        <div class="flex-row">
                            <div class="col-xs-12 col-md-8">
                                <label>
                                    <input type="radio" name="delivery" value="3">
                                    <span>Доставка грузоперевозчиком по Беларуси (России, Украине):</span>
                                </label>
                                <div class="radio-block-descr">
                                    <ul>
                                        <li>Ваш заказ будет доставлен грузоперевозчиком в течение 2-8 дней.</li>
                                        <li>Стоимость доставки зависит от пункта назначения и веса отправления.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="form-row flex-row flex-row-padding">
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <label class="input">
                                    <span class="input-label">Населенный пункт<sup>*</sup></span>
                                    <div class="input-in">
                                        <input type="text" name="gruz[city]" value="Минск, Минская область" disabled="disabled"/>
                                    </div>
                                </label>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <label class="input">
                                    <span class="input-label">Улица<sup>*</sup></span>
                                    <div class="input-in">
                                        <input type="text" name="gruz[street]" value=""/>
                                    </div>
                                </label>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="form-row flex-row form-row-nopadd">
                                    <label class="col-xs input">
                                        <span class="input-label">Дом<sup>*</sup></span>
                                        <div class="input-in">
                                            <input type="text" name="gruz[house]" value=""/>
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
                </div>

                <div class="form-checkout-section">
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
                                    <input type="radio" name="payment" value="1">
                                    <span>Наличными</span>
                                    <div class="radio-block-descr">Оплата принимается в момент получения товара.</div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="radio-block">
                        <div class="flex-row" style="">
                            <div class="col-xs-12 col-md-8">
                                <label>
                                    <input type="radio" name="payment" value="2">
                                    <span>Банковской картой курьеру/менеджеру</span>
                                    <div class="radio-block-descr">Оплата принимается в момент получения товара.</div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-checkout-footer">
                    <div class="flex-row flex-row-padding">
                        <div class="col-xs-12 col-md-6">
                            <div id="result-ajax-left">
                                <div class="dot-row">
                                    <div class="dot-col">Итого 1 товар</div>
                                    <div class="dot-col">
                                        <div class="product-price product-price-small">
                                            <span>82.60</span>
                                            <sup>руб</sup>
                                        </div>
                                    </div>
                                </div>

                                <div class="dot-row">
                                    <div class="dot-col">Моя скидка</div>
                                    <div class="dot-col">
                                        <div class="product-price product-price-small">
                                            <span>без скидки</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="dot-row">
                                    <div class="dot-col">Доставка</div>
                                    <div class="dot-col">
                                        <div class="product-price product-price-small">
                                            <span>самовывоз</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="dot-row">
                                    <div class="dot-col">Стоимость доставки</div>
                                    <div class="dot-col">
                                        <div class="product-price product-price-small">
                                            <span>бесплатно</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="dot-row">
                                    <div class="dot-col">Оплата</div>
                                    <div class="dot-col">
                                        <div class="product-price product-price-small">
                                            <span>наличными</span>
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
                                            <span>82.60</span>
                                            <sup>руб</sup>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <label class="input">
                                        <span class="input-label">Комментарий</span>
                                        <div class="input-in">
                                            <textarea></textarea>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <p>
                                <label>
                                    <input type="checkbox"  class="" />
                                    <span>Я даю согласие на обработкуперсональных данных.</span>
                                </label>
                            </p>

                            <input type="submit" class="button button--bgred button--big" value="Оформить">
                        </div>
                    </div>
                </div>

            </div>

        </form>
    </div>
</section>














