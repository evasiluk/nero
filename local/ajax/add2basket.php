<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

if($_REQUEST["product_id"]) {
    if (CModule::IncludeModule("catalog"))
    {

        Add2BasketByProductID(
            $_REQUEST["product_id"],
            $_REQUEST["quantity"],
            array(),
            array()
        );

    }
}

