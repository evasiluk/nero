<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказы");
?>
<div class="maxwrap">
    <?
    global $USER;
    if($USER->IsAuthorized()):
    ?>
    <?$APPLICATION->IncludeComponent(
        "bitrix:sale.personal.order.list",
        "list",
        Array(
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "ALLOW_INNER" => "N",
            "CACHE_GROUPS" => "Y",
            "CACHE_TIME" => "3600",
            "CACHE_TYPE" => "A",
            "DEFAULT_SORT" => "STATUS",
            "HISTORIC_STATUSES" => array(""),
            "ID" => $ID,
            "NAV_TEMPLATE" => "",
            "ONLY_INNER_FULL" => "N",
            "ORDERS_PER_PAGE" => "20",
            "PATH_TO_BASKET" => "",
            "PATH_TO_CANCEL" => "",
            "PATH_TO_CATALOG" => "/catalog/",
            "PATH_TO_COPY" => "",
            "PATH_TO_DETAIL" => "",
            "PATH_TO_PAYMENT" => "payment.php",
            "REFRESH_PRICES" => "N",
            "RESTRICT_CHANGE_PAYSYSTEM" => array("0"),
            "SAVE_IN_SESSION" => "Y",
            "SET_TITLE" => "Y"
        ),
    $component
    );?>
    <?else:?>
        <div class="usercontent bg--white basket-is-empty js-basket-is-empty">
            <div class="wrap wrap-content">
                <a href="/content/personal/register/">Зарегистрируйтесь</a> и/или <a href="/content/personal/auth/">авторизуйтесь</a> для просмотра истории заказов.
            </div>
        </div>
    <?endif?>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>