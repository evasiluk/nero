<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

if (CModule::IncludeModule("catalog"))
{

    Add2BasketByProductID(
        413,
        2,
        array(),
        array()
    );

}