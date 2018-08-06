<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); 

CModule::IncludeModule( 'main' );
CModule::IncludeModule('iblock');

foreach($arResult['BASKET'][0]['PROPS'] as $prop)
{
	if($prop['CODE'] == 'STORE'){
		$arResult['ORDER_STORE'] = $prop['VALUE'];
	}
}

$arResult["UPDATED_ORDERS"] = FALSE;

$uf_arresult = CIBlockSection::GetList(Array(), Array("IBLOCK_ID" => 25, "NAME" => $arResult["ID"])); 

if($uf_value = $uf_arresult->GetNext()){ 

	$res = CIBlockElement::GetList(
		array(), 
		array("IBLOCK_TYPE"=>"1c_catalog", "IBLOCK_CODE"=>"order_update", "SECTION_CODE"=>'order_'.$arResult["ID"], 'INCLUDE_SUBSECTIONS'=>'Y'), 
		false,  
		false, 
		Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_*")
	);

	$i = 1; $count = 0;
	while($ob = $res->GetNextElement()){ 
		$count++;
		if($count == 1) {
			$arResult['BASKET'] = array();
		}
		$edited_product = false;

		$arFields = $ob->GetFields();
		$arProps = $ob->GetProperties();

		$arResult['BASKET'][$i]['PRODUCT_ID']       = $arFields['NAME'];
		$arResult['BASKET'][$i]['ORIGINAL']         = $arProps["original"]["VALUE"];
		$arResult['BASKET'][$i]['NAME']             = $arProps["name"]["VALUE"];
		$arResult['BASKET'][$i]['BRAND']            = $arProps["brand"]["VALUE"];
		$arResult['BASKET'][$i]['MODEL']            = $arProps["model"]["VALUE"];
		$arResult['BASKET'][$i]['START_AMOUNT']     = $arProps["start_amount"]["VALUE"];
		$arResult['BASKET'][$i]['START_PRICE']      = floatval($arProps["start_summ"]["VALUE"]);
		$arResult['BASKET'][$i]['START_DISCOUNT']   = $arProps["start_discount"]["VALUE"];
		$arResult['BASKET'][$i]['START_SUMM']       = floatval($arProps["start_price"]["VALUE"]);
		$arResult['BASKET'][$i]['CURRENT_AMOUNT']   = $arProps["current_amount"]["VALUE"];
		$arResult['BASKET'][$i]['CURRENT_PRICE']    = floatval($arProps["current_summ"]["VALUE"]);
		$arResult['BASKET'][$i]['CURRENT_DISCOUNT'] = $arProps["current_discount"]["VALUE"];	
		$arResult['BASKET'][$i]['CURRENT_SUMM']     = floatval($arProps["current_price"]["VALUE"]);
		$arResult['BASKET'][$i]['RESERVE']          = $arProps["reserve"]["VALUE"];
		
		if($arResult['BASKET'][$i]['START_DISCOUNT'] != 0){
			$arResult['BASKET'][$i]['START_DISCOUNT_PRICE'] = floatval($arResult['BASKET'][$i]['START_PRICE']*(1 - $arResult['BASKET'][$i]['START_DISCOUNT']/100));
			$arResult['BASKET'][$i]['START_SUMM'] = floatval($arResult['BASKET'][$i]['START_SUMM']*(1 - $arResult['BASKET'][$i]['START_DISCOUNT']/100));
		}
		else{
			$arResult['BASKET'][$i]['START_DISCOUNT_PRICE'] = $arResult['BASKET'][$i]['START_PRICE'];
		}
		
		if($arResult['BASKET'][$i]['CURRENT_DISCOUNT'] != 0){
			$arResult['BASKET'][$i]['CURRENT_DISCOUNT_PRICE'] = floatval($arResult['BASKET'][$i]['CURRENT_PRICE']*(1 - $arResult['BASKET'][$i]['CURRENT_DISCOUNT']/100));
			$arResult['BASKET'][$i]['CURRENT_SUMM'] = floatval($arResult['BASKET'][$i]['CURRENT_SUMM']*(1 - $arResult['BASKET'][$i]['CURRENT_DISCOUNT']/100));
		}
		else{
			$arResult['BASKET'][$i]['CURRENT_DISCOUNT_PRICE'] = $arResult['BASKET'][$i]['CURRENT_PRICE'];
		}
		
		if($arResult['BASKET'][$i]['CURRENT_AMOUNT'] == 0){
			$arResult['BASKET'][$i]['RESERVE'] = 'Удалён';
		}
		
		if($arProps["original"]["VALUE"] == 'Да'){
			
			if($arResult['BASKET'][$i]['START_AMOUNT'] != $arResult['BASKET'][$i]['CURRENT_AMOUNT']){
				$arResult['BASKET'][$i]['AMOUNT'] = $arResult['BASKET'][$i]['CURRENT_AMOUNT'];
				//$edited_product = true;
			}
			
			if($arResult['BASKET'][$i]['START_PRICE'] != $arResult['BASKET'][$i]['CURRENT_PRICE']){
				$arResult['BASKET'][$i]['PRICE'] = floatval($arResult['BASKET'][$i]['CURRENT_PRICE']);
				//$edited_product = true;
			}		
			
			if($arResult['BASKET'][$i]['START_DISCOUNT'] != $arResult['BASKET'][$i]['CURRENT_DISCOUNT']){
				$arResult['BASKET'][$i]['DISCOUNT'] = $arResult['BASKET'][$i]['CURRENT_DISCOUNT'];
				//$edited_product = true;
			}	
			/*
			if($edited_product){
				$arResult['BASKET'][$i]['CLASS']  = 'edited_product';
			}
			*/		
		}
		else{
			/*
			if(!isset($arResult['BASKET'][$i]['CLASS'])){
				$arResult['BASKET'][$i]['CLASS']  = 'additional_product';
			}
			*/
		}
		if(!isset($arResult['BASKET'][$i]['CLASS'])){
		
			switch($arResult['BASKET'][$i]['RESERVE']){
				case 'Зарезервирован':
					$arResult['BASKET'][$i]['CLASS']  = 'reserved_product';
					break;
				case 'Не зарезервирован':
					$arResult['BASKET'][$i]['CLASS']  = 'not_reserved_product';
					break; 
				case 'Удалён':
					$arResult['BASKET'][$i]['CLASS']  = 'deleted_product';
					break;
				default:
					$arResult['BASKET'][$i]['CLASS']  = '';
			}
		}
		
		$i++;
	 
	}
	
	if($count > 0){
		$arResult["UPDATED_ORDERS"] = TRUE;
	}
	
}

?>