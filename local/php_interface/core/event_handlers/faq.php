<?php
CModule::IncludeModule("iblock");

AddEventHandler('form', 'onBeforeResultAdd', 'my_onBeforeResultAdd');

function my_onBeforeResultAdd($WEB_FORM_ID, &$arFields, &$arrVALUES)
{
    global $APPLICATION;

    //print_pre($arrVALUES); exit;

    if($arrVALUES["WEB_FORM_ID"] == 1) {
        $el = new CIBlockElement;
        $arNew = array("IBLOCK_ID" => 18,
            "NAME" => $arrVALUES["form_text_1"],
            "PREVIEW_TEXT"   => $arrVALUES["form_textarea_3"],
            "ACTIVE" =>"N",
            "PROPERTY_VALUES" => array("EMAIL" => $arrVALUES["form_email_2"])
        );
        $ELEMENT_ID = $el->Add($arNew);

    } elseif($arrVALUES["WEB_FORM_ID"] == 3) {
        $el = new CIBlockElement;
        $arNew = array("IBLOCK_ID" => 49,
            "NAME" => $arrVALUES["form_text_12"],
            "PREVIEW_TEXT"   => $arrVALUES["form_text_12"],
            "ACTIVE" =>"N",
            "PROPERTY_VALUES" => array("EMAIL" => $arrVALUES["form_text_13"])
        );
        $ELEMENT_ID = $el->Add($arNew);
    } elseif($arrVALUES["WEB_FORM_ID"] == 5) {
        $user = new CUser;

        $country = "";
        switch($arrVALUES["form_dropdown_SIMPLE_QUESTION_838"]) {
            case 23: $country = 4; //беларусь
                break;
            case 24: $country = 14; //украина
                break;
            case 25: $country = 1;  //россия
                break;
        }


        $arFields = array(
            'NAME'             => $arrVALUES["form_text_22"],
            'EMAIL'            => $arrVALUES["form_email_26"],
            'LOGIN'            => $arrVALUES["form_email_26"], // минимум 3 символа
            'ACTIVE'           => 'Y',
            'PASSWORD'         => $arrVALUES["form_password_28"], // минимум 6 символов
            'CONFIRM_PASSWORD' => $arrVALUES["form_password_28"],
            'GROUP_ID'         => array(26),
            'PERSONAL_PHONE'   => $arrVALUES["form_text_27"],
            "PERSONAL_COUNTRY" => $country,
            "UF_NERO_SITE"     => CURRENT_USER_HOST
        );


        $ID = $user->Add($arFields);
        if($ID) {
            global $USER;
            $USER->Authorize($ID);
        }
        //return false;
    }
}

AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "faq_sender");

function faq_sender(&$arFields) {
    //return true;
    if($arFields["IBLOCK_ID"] == 18) {
        $id = $arFields["ID"];
        $iblock_id = $arFields["IBLOCK_ID"];

        $el = get_element($id, $iblock_id);
        if($el["ACTIVE"] == "Y" && !$el["PROPS"]["SEND"]["VALUE"] && $el["PROPS"]["EMAIL"]["VALUE"]) {
            CIBlockElement::SetPropertyValueCode($id, "SEND", "511");

            $a["QUESTION"] = $el["PREVIEW_TEXT"];
            $a["ANSWER"] = $el["DETAIL_TEXT"];
            $a["EMAIL"] = $el["PROPS"]["EMAIL"]["VALUE"];

            //print_pre($a); exit;
            CEvent::Send("ANSWER_SEND", "s1", $a);
        }

    } else if($arFields["IBLOCK_ID"] == 49) {
        $id = $arFields["ID"];
        $iblock_id = $arFields["IBLOCK_ID"];

        $el = get_element($id, $iblock_id);
        if($el["ACTIVE"] == "Y" && !$el["PROPS"]["SEND"]["VALUE"] && $el["PROPS"]["EMAIL"]["VALUE"]) {
            CIBlockElement::SetPropertyValueCode($id, "SEND", "512");

            $a["QUESTION"] = $el["PREVIEW_TEXT"];
            $a["ANSWER"] = $el["DETAIL_TEXT"];
            $a["EMAIL"] = $el["PROPS"]["EMAIL"]["VALUE"];

            CEvent::Send("ANSWER_SEND", "s2", $a);
        }


    }
}

function get_element($element_id, $iblock_id) {
    $arSelect = Array();
    $arFilter = Array("IBLOCK_ID" => $iblock_id, "ID" => $element_id);


    $dbEl = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    $element = array();

    while($obEl = $dbEl->GetNextElement()) {
        $arFields = $obEl->GetFields() ;
        $arProps = $obEl->GetProperties();
        $element = $arFields;
        $element["PROPS"] = $arProps;
    }

    return $element;
}