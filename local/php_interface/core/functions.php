<?php
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;
CModule::IncludeModule('highloadblock');

function print_pre()
{
    $args = func_get_args();
    foreach($args as $arg){
        echo '<pre>';
        if(!is_scalar($arg)) print_r($arg);
        else var_dump($arg);
        echo '</pre>';
    }
}

function get_hl_data($id) {
    $hlbl = $id;
    $hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();

    $entity = HL\HighloadBlockTable::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();

    $arFilter = array();

    $arSelect = array('*'); // выбираем все поля
    $arOrder = array("ID"=>"ASC");

    $rsData = $entity_data_class::getList(array(
        "select" => $arSelect,
        "filter" => $arFilter,
        "limit" => '100000',
        "order" => $arOrder
    ));

    $arResult = array();

    while($arData = $rsData->Fetch())
    {
        $arResult[] = $arData;
    }

    return $arResult;
}


function catalog_linked_props() {

$hlbl = 1;
$hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();

$entity = HL\HighloadBlockTable::compileEntity($hlblock);
$entity_data_class = $entity->getDataClass();

$arFilter = array();

$arSelect = array('*'); // выбираем все поля
$arOrder = array("ID"=>"ASC");

$rsData = $entity_data_class::getList(array(
    "select" => $arSelect,
    "filter" => $arFilter,
    "limit" => '100000',
    "order" => $arOrder
));

$arResult = array();

while($arData = $rsData->Fetch())
{
    $props = explode(",",$arData["UF_PROPS"]);
    foreach($props as $prop) {
        if(trim($prop)) {
            $arResult[$arData["UF_TYPE"]][] = trim($prop);
        }

    }
}

return $arResult;
}

function get_iblock_properties($iblock) {
    $properties = CIBlockProperty::GetList(Array("id"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$iblock));
    $props = array();
    while ($prop_fields = $properties->GetNext())
    {
        $props[$prop_fields["CODE"]] = $prop_fields["ID"];
    }

    return $props;
}

function convert_valute($value, $iblock_id, $date = "") {
    $valute_from = "EUR";
    $valute_to = "BYN";

    switch($iblock_id) {
        case 30: $valute_to = "BYN";
           break;
        case 59:
        case 60: $valute_to = "RUB";
            break;
        case 58: $valute_to = "UAH";
            break;
        case 64: $valute_to = "EUR";
            break;
    }
    $price = number_format(CCurrencyRates::ConvertCurrency($value, $valute_from, $valute_to, $date), 2, '.', '');
    return $price;
}

function get_currency_code($iblock_id) {
    $code = "BYN";

    switch($iblock_id) {
        case 30: $code = "BYN";
            break;
        case 59:
        case 60: $code = "RUB";
            break;
        case 58: $code = "UAH";
            break;
        case 64: $code = "EUR";
            break;
    }

    return $code;
}

function get_region_catalog_iblock() {
    $iblock_id = 30;
    switch($_SERVER["HTTP_HOST"]) {
        case BY_HOST: $iblock_id = 30;
            break;
        case UA_HOST : $iblock_id = 58;
            break;
        case SPB_HOST : $iblock_id = 59;
            break;
        case MSK_HOST : $iblock_id = 60;
            break;
        case EN_HOST : $iblock_id = 64;
            break;
    }

    return $iblock_id;
}

function get_valute_short($iblock_id) {
    switch($iblock_id) {
        case 30:
        case 59:
        case 60: $valute_short = "руб.";
            break;
        case 58: $valute_short = "грв.";
            break;
        case 64: $valute_short = "eur.";
            break;
        default: $valute_short = "руб.";
    }


    return $valute_short;
}

function is_dealer($uid) {

}



/**
 * @param $bytes
 * @param int $precision
 * @return string
 */
function formatBytes($bytes, $precision = 2)
{
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    // Uncomment one of the following alternatives
    $bytes /= pow(1024, $pow);
    // $bytes /= (1 << (10 * $pow));

    return round($bytes, $precision) . ' ' . $units[$pow];
}

/**
 * @param $value
 * @param $one
 * @param $two
 * @param $five
 * @return mixed
 */
function getCorrectEnding( $value, $one, $two, $five )
{
    $value = abs( (int)$value );
    if( ($value % 100 >= 11) && ($value % 100 <= 19) ){
        return $five;
    } else {
        switch( $value % 10 ){
            case 1:
                return $one;
            case 2: case 3: case 4:
            return $two;
            default:
                return $five;
        }
    }
}

/**
 * @param $array
 * @return mixed
 */
function &first(&$array)
{
    reset($array);
    return $array[key($array)];
}

/**
 * @param $array
 * @return mixed
 */
function &last(&$array)
{
    end($array);
    return $array[key($array)];
}

/**
 * @param string $text String to truncate.
 * @param integer $length Length of returned string, including ellipsis.
 * @param string $ending Ending to be appended to the trimmed string.
 * @param boolean $exact If false, $text will not be cut mid-word
 * @param boolean $considerHtml If true, HTML tags would be handled correctly
 * @return string Trimmed string.
 */
function truncate($text, $length = 100, $ending = '...', $exact = false, $considerHtml = true)
{
    if ($considerHtml) {
        // if the plain text is shorter than the maximum length, return the whole text
        if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
            return $text;
        }
        // splits all html-tags to scanable lines
        preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
        $total_length = strlen($ending);
        $open_tags = array();
        $truncate = '';
        foreach ($lines as $line_matchings) {
            // if there is any html-tag in this line, handle it and add it (uncounted) to the output
            if (!empty($line_matchings[1])) {
                // if it's an "empty element" with or without xhtml-conform closing slash
                if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
                    // do nothing
                    // if tag is a closing tag
                } else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
                    // delete tag from $open_tags list
                    $pos = array_search($tag_matchings[1], $open_tags);
                    if ($pos !== false) {
                        unset($open_tags[$pos]);
                    }
                    // if tag is an opening tag
                } else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
                    // add tag to the beginning of $open_tags list
                    array_unshift($open_tags, strtolower($tag_matchings[1]));
                }
                // add html-tag to $truncate'd text
                $truncate .= $line_matchings[1];
            }
            // calculate the length of the plain text part of the line; handle entities as one character
            $content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
            if ($total_length+$content_length> $length) {
                // the number of characters which are left
                $left = $length - $total_length;
                $entities_length = 0;
                // search for html entities
                if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
                    // calculate the real length of all entities in the legal range
                    foreach ($entities[0] as $entity) {
                        if ($entity[1]+1-$entities_length <= $left) {
                            $left--;
                            $entities_length += strlen($entity[0]);
                        } else {
                            // no more characters left
                            break;
                        }
                    }
                }
                $truncate .= substr($line_matchings[2], 0, $left+$entities_length);
                // maximum lenght is reached, so get off the loop
                break;
            } else {
                $truncate .= $line_matchings[2];
                $total_length += $content_length;
            }
            // if the maximum length is reached, get off the loop
            if($total_length>= $length) {
                break;
            }
        }
    } else {
        if (strlen($text) <= $length) {
            return $text;
        } else {
            $truncate = substr($text, 0, $length - strlen($ending));
        }
    }
    // if the words shouldn't be cut in the middle...
    if (!$exact) {
        // ...search the last occurance of a space...
        $spacepos = strrpos($truncate, ' ');
        if (isset($spacepos)) {
            // ...and cut the text in this position
            $truncate = substr($truncate, 0, $spacepos);
        }
    }
    // add the defined ending to the text
    $truncate .= $ending;
    if($considerHtml) {
        // close all unclosed html-tags
        foreach ($open_tags as $tag) {
            $truncate .= '</' . $tag . '>';
        }
    }
    return $truncate;
}