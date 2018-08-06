<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Loader,
    Rover\GeoIp\Location;
if (Loader::includeModule('rover.geoip')){
    if($_COOKIE["RegionCheck"] != true) {
        $current_host = $_SERVER["HTTP_HOST"];
        $current_ip = Location::getCurIp();
        //109.205.253.39 - питер
        //178.219.186.12 - москва
        //94.244.22.168 - киев
        //91.149.175.42 - беларусь
        $current_ip = "91.149.175.42";
        $location = Location::getInstance($current_ip);
        $city = $location->getCityName();
        $country = $location->getCountryCode();




        if($country == "BY" && $current_host != BY_HOST) {
            $arResult["PHRASE"] = "Беларусь";
            $arResult["HOST"] = BY_HOST;
        } elseif($country == "UA" && $current_host != UA_HOST) {
            $arResult["PHRASE"] = "Украина";
            $arResult["HOST"] = UA_HOST;
        } elseif($country == "RU" && $city == "Санкт-Петербург" && $current_host != SPB_HOST ) {
            $arResult["PHRASE"] = "Россия(Санкт-Петербург)";
            $arResult["HOST"] = SPB_HOST;
        } elseif($country == "RU" && $city != "Санкт-Петербург" && $current_host != MSK_HOST) {
            $arResult["PHRASE"] = "Россия (Москва)";
            $arResult["HOST"] = MSK_HOST;
        }
    }
    //print_pre($_COOKIE);
}

//________________________ №2
//$current_host = $_SERVER["HTTP_HOST"];
//$regions = array(
//    "nero.test.astronim.com" => array("CODE" => "BY", "NAME" => "Беларусь"),
//    "nero-ua.test.astronim.com" => array("CODE" => "UA", "NAME" => "Украина"),
//    "nero-msk.test.astronim.com" => array("CODE" => "MSK", "NAME" => "Россия (Москва)"),
//    "nero-spb.test.astronim.com" => array("CODE" => "SPB", "NAME" => "Россия (Санкт-Петербург)"),
//);
//
//$arResult["NAME_BY_HOST"] = $regions[$current_host];

//$arResult = array();

$this->IncludeComponentTemplate();
?>

