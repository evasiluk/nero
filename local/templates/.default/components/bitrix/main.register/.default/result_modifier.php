<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

foreach($arResult['USER_PROPERTIES']['DATA'] as $code => &$property){
    if($property['USER_TYPE_ID'] == 'enumeration'){
        $rs = CUserTypeEntity::GetList( [], ['FIELD_NAME' => $property['FIELD_NAME']] ) -> Fetch();
        $rs = CUserFieldEnum::GetList(array(), array(
            "USER_FIELD_ID" => $rs['ID'],
        ));

        while($ar = $rs->GetNext())
            $property['VALUES'][$ar['ID']] = $ar['VALUE'];
    }
}