<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Дилер");
?>
<div class="usercontent bg--white wrap wrap-content">
    <?$APPLICATION->IncludeComponent(
        "bitrix:forum.user.profile.edit",
        "managers_user_edit",
        Array(
            "CACHE_TIME" => "0",
            "CACHE_TYPE" => "A",
            "SET_NAVIGATION" => "Y",
            "SET_TITLE" => "Y",
            "UID" => $_REQUEST["uid"],
            "URL_TEMPLATES_PROFILE_VIEW" => "",
            "USER_PROPERTY" => array("UF_SERVICES_ADDITION","UF_SERVICES_WHERE","UF_SERVICES","UF_NOTIFY_DATE")
        )
    );?>
</div>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>