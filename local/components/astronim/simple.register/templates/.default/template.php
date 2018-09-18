<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>


<?if($arResult["USER_REGISTERED"]):?>
    <section class="wrap form-wrap">
        <div class="reg-form">
            <div class="usercontent">
                <h2>Спасибо!</h2>
                <p>Вы успешно зарегистрированы.</p>
            </div>
        </div>
    </section>
<?else:?>
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <?if($arResult["ERRORS"]):?>
        <div class="js-form-error-template">
            <ol>
                <?foreach($arResult["ERRORS"] as $er):?>
                    <li><?=$er?></li>
                <?endforeach?>
            </ol>
        </div>
    <?endif?>

    <section class="wrap form-wrap">
        <form action="#" class="reg-form js-form" method="post" id="simple_register">
            <h5 class="align-center">Регистрация</h5>

            <div class="form-row flex-row">
                <label class="col-xs">
                    <div id="ajax_result" class="form-error"></div>
                </label>
            </div>

            <div class="form-row flex-row">
                <label class="col-xs">
                    <div class="input">
                        <span class="input-label">Имя<sup>*</sup></span>
                        <div class="input-in">
                            <input type="text" placeholder="" required data-parsley-required  class="inputtext"  name="name" value="<?=$_POST["name"]?>" size="0" />
                            <span class="focus-border"></span>
                            <span class="input-note">Например, Эмануил</span>
                        </div>
                    </div>
                </label>
            </div>
            <div class="form-row flex-row">
                <label class="col-xs">
                    <div class="input">
                        <span class="input-label">E-mail (логин)<sup>*</sup></span>
                        <div class="input-in">
                            <input type="email" placeholder="" required data-parsley-required  class="inputtext"  name="email" value="<?=$_POST["email"]?>" size="0" />
                            <span class="focus-border"></span>
                            <span class="input-note">Например, some@email.com</span>
                        </div>
                    </div>
                </label>
            </div>
            <div class="form-row flex-row">
                <div class="col-xs">
                    <div class="input">
                        <span class="input-label">Страна</span>
                        <select data-select  class="inputselect"  name="country">
                            <option value="4">Беларусь</option>
                            <option value="14">Украина</option>
                            <option value="1">Россия</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-row flex-row">
                <label class="col-xs">
                    <div class="input">
                        <span class="input-label">Телефон<sup>*</sup></span>
                        <div class="input-in">
                            <input type="text" placeholder="" required data-parsley-required  class="inputtext"  name="phone" value="<?=$_POST["phone"]?>" size="0" />
                            <span class="focus-border"></span>
                            <span class="input-note">Например, +375291111111</span>
                        </div>
                    </div>
                </label>
            </div>
            <div class="form-row flex-row">
                <label class="col-xs">
                    <div class="input">
                        <span class="input-label">Пароль<sup>*</sup></span>
                        <div class="input-in">
                            <input type="password" name="password" required data-parsley-required id="register_password">
                            <span class="focus-border"></span>
                            <span class="input-note"></span>
                        </div>
                    </div>
                </label>
            </div>
            <div class="form-row flex-row">
                <label class="col-xs">
                    <div class="input">
                        <span class="input-label">Подтверждение пароля<sup>*</sup></span>
                        <div class="input-in">
                            <input type="password" name="password_confirm" data-parsley-required id="register_password_confirm" data-parsley-equalto="#register_password" required="">
                            <span class="focus-border"></span>
                            <span class="input-note"></span>
                        </div>
                    </div>
                </label>
            </div>

            <div class="form-row flex-row">
                <div class="col-xs">
                    <div class="g-recaptcha" data-sitekey="<?=GRECAPTCHA_PUBLIC?>"></div>
                </div>
            </div>

            <div class="form-row flex-row form-footer">
                <div class="col-xs center-xs">
                    <p><button type="submit" class="button button--big button-hover--bgblack" id="send">Отправить</button></p>
                    <div class="form-note">* Поля обязательные для заполнения</div>
                </div>
            </div>
        </form>
    </section>
<?endif?>









