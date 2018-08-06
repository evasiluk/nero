<?php
use Astronim\Helper as Helper;
use \Bitrix\Iblock\ElementTable;
use \Bitrix\Iblock\PropertyTable;
CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");

Bitrix\Main\EventManager::getInstance()->addEventHandler(
    "main",
    "OnBeforeEventAdd",
    ["MailEventHandler", "onBeforeEventAddHandler"]
);

function r() {
    return 1235;
}

class MailEventHandler
{
    static function onBeforeEventAddHandler(&$event, &$lid, &$arFields, &$message_id, &$files)
    {
        if (strpos($event, 'FORM_FILLING_') !== false) {
            if (!is_array($files)) $files = [];

            foreach ($arFields as $key => $field) {
                if ($link = self::getLinkFromField($field)) {
                    if ($arFile = self::getFileFromLink($link)) {
                        $files[] = $arFile['FILE_ID'];
                    }
                }
            }

        }
    }

    static function getLinkFromField($field)
    {
        preg_match("/href=[\"'](.*form_show_file.*)[\"']/", $field, $out);

        return ($out[1] ?: false);
    }

    static function getFileFromLink($link)
    {
        $uri = new \Bitrix\Main\Web\Uri($link);
        parse_str($uri->getQuery(), $query);
        return CFormResult::GetFileByHash($query["rid"], $query["hash"]);
    }
}

Bitrix\Main\EventManager::getInstance()->addEventHandler("main", "OnBeforeUserRegister", "OnBeforeUserRegisterHandler");
Bitrix\Main\EventManager::getInstance()->addEventHandler("main", "OnBeforeUserUpdate", "OnBeforeUserRegisterHandler");
function OnBeforeUserRegisterHandler(&$args)
{
    if($args['ID'])
        $before_args = \Bitrix\Main\UserTable::getById($args['ID'])->fetch();

//    if (
//        $args['ID']
//        && "Y" == $args['ACTIVE']
//        && 'Y' != $before_args['ACTIVE']
//    ) {
//        $psswd = uniqid();
//        $args['PASSWORD'] = $psswd;
//        $args['PASSWORD_CONFIRM'] = $psswd;
//        $args['EMAIL'] = $before_args['EMAIL'];
//        CEvent::Send('USER_PASSWORD', SITE_ID, $args);
//    }

    if ($args['EMAIL'])
        $args['LOGIN'] = trim($args['EMAIL']);

    if (!$before_args) {
        $return = true;
        
        if ($ar = CUser::GetList($by = "timestamp_x", $order = "desc", ['EMAIL' => $args['EMAIL']])->GetNext()) {
            $GLOBALS['APPLICATION']->ThrowException('Извините, этот e-mail уже используется. Если это ваш e-mail, вы можете воспользоваться функцией восстановления пароля');
            $return = false;
        }

        return $return;
    }
}




AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("CatalogClass", "OnElementHandler"));
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("CatalogClass", "OnElementHandler"));

class CatalogClass {
    private static $iblocks = array(
        "iblock_msk" => 60,
        "iblock_spb" => 59,
        "iblock_ua" => 58,

    );

    private static $offers_ib = array(
        "iblock_msk" => 62,
        "iblock_spb" => 61,
        "iblock_ua" => 63,
    );

    private static $current_sibling = 0;
    private static $current_sibling_iblock = 0;
    private static $current_sibling_cml = 0;
    private static $current_sibling_cml_iblock = 0;
    private static $section_code = "";

    function OnElementHandler(&$arFields) {

        //торговые предложения
        if($arFields["IBLOCK_ID"] == 31) {
            // определяем элемент и код его раздела
            $element_id = $arFields["ID"];
            $iblock_id = $arFields["IBLOCK_ID"];
            $element = self::get_element($element_id, $iblock_id);

            //print_pre($element); exit;
            foreach(self::$offers_ib as $reg_iblock) {
                self::$current_sibling_cml_iblock = $reg_iblock;

                $el = self::get_sibling($reg_iblock, $element["NAME"]);
                if($el) {
                    self::$current_sibling_cml = $el["ID"];
                } else {
                    $id = self::create_sibling($reg_iblock, false, $element["NAME"]);
                    self::$current_sibling_cml = $id;
                }

                // ___________________________________________________________update свойств предложений
                //preview picture
                self::updatePreviewPictureCml($element["PREVIEW_PICTURE"]);
                //detail picture
                self::updateDetailPictureCml($element["DETAIL_PICTURE"]);
                //цветовой код
                self::updateColorCodeCml($element["PROPS"]["COLOR_CODE"]["VALUE"]);
                // доп фото
                self::updateMorePhotoCml($element["PROPS"]["MORE_PHOTO"]["VALUE"]);
                //товар товарного предложения
                self::updateParentProduct($element["PROPS"]["CML2_LINK"]["VALUE"]);
                //цены
                self::updatePriceCml($element["PROPS"]);
            }


        }

        //товары
        if($arFields["IBLOCK_ID"] == 30) {

            // определяем элемент и код его раздела
            $element_id = $arFields["ID"];
            $iblock_id = $arFields["IBLOCK_ID"];
            $section_id = $arFields["IBLOCK_SECTION_ID"];

            $section = self::get_section($iblock_id, $section_id);
            self::$section_code = $section[0]["CODE"];
            $element = self::get_element($element_id, $iblock_id);

            //пробегаемся по инфоблокам регионов и проверяем наличие такого же товара
            //при отсутствии - создаем
            foreach(self::$iblocks as $reg_iblock) {
                self::$current_sibling_iblock = $reg_iblock;

                $el = self::get_sibling($reg_iblock, $element["NAME"], self::$section_code);
                if($el) {
                    self::$current_sibling = $el["ID"];
                } else {
                    $section_id = self::get_sibling_section_id($reg_iblock, self::$section_code);
                    $id = self::create_sibling($reg_iblock, $section_id, $element["NAME"]);
                    self::$current_sibling = $id;
                }

                // ___________________________________________________________update свойств


               //preview picture
               self::updatePreviewPicture($element["PREVIEW_PICTURE"]);
               //detail picture
               self::updateDetailPicture($element["DETAIL_PICTURE"]);
               //preview text
               self::updatePreviewText($element["PREVIEW_TEXT"]);

               //detail text
               self::updateDetailText($element["DETAIL_TEXT"]);

                //цветовой код
               self::updateColorCode($element["PROPS"]["COLOR_CODE"]["VALUE"]);

                //тип
               if($element["PROPS"]["type"]["VALUE"]) {
                   self::updateType($element["PROPS"]["type"]["VALUE_ENUM_ID"]);
               }

               //линейка
               if($element["PROPS"]["line"]["VALUE"]) {
                   self::updateLine($element["PROPS"]["line"]["VALUE_ENUM_ID"]);
               }

               //Дальность действия
               if($element["PROPS"]["ACTION_LENGTH"]["VALUE"]) {
                   self::updateActionLength($element["PROPS"]["ACTION_LENGTH"]["VALUE"]);
               }

               //Дополнительные иконки
               if($element["PROPS"]["MORE_ICONS"]["VALUE"]) {
                   self::updateMoreIcons($element["PROPS"]["MORE_ICONS"]["VALUE"]);
               }

               //Дополнительные фото
               if($element["PROPS"]["MORE_PHOTO"]["VALUE"]) {
                   self::updateMorePhoto($element["PROPS"]["MORE_PHOTO"]["VALUE"]);
               }

               //Особенности
               if($element["PROPS"]["OSOBENNOSTY"]["VALUE"]) {
                   self::updateOsobennosty($element["PROPS"]["OSOBENNOSTY"]["VALUE"]);
               }

               //Характеристики
               if($element["PROPS"]["HARACTERISTIKY"]["VALUE"]) {
                   self::updateHaracteristiky($element["PROPS"]["HARACTERISTIKY"]["VALUE"]);
               }

               //Характеристики HTML
               if($element["PROPS"]["HARACTERISTIKY_HTML"]["VALUE"]["TEXT"]) {
                   self::updateHaracteristikyHtml($element["PROPS"]["HARACTERISTIKY_HTML"]["~VALUE"]["TEXT"]);
               }

               //Установка
               if($element["PROPS"]["INSTALLING"]["VALUE"]["TEXT"]) {
                   self::updateInstalling($element["PROPS"]["INSTALLING"]["~VALUE"]["TEXT"]);
               }

               //Управление
               if($element["PROPS"]["CONTROLL_HTML"]["VALUE"]["TEXT"]) {
                   self::updateControllHtml($element["PROPS"]["CONTROLL_HTML"]["~VALUE"]["TEXT"]);
               }

               //Управление (фоновая картинка)
               if($element["PROPS"]["CONTROLL_IMG"]["VALUE"]) {
                   self::updateControllImg($element["PROPS"]["CONTROLL_IMG"]["VALUE"]);
               }

               //Файлы для скачивания
               if($element["PROPS"]["FILES"]["VALUE"]) {
                   self::updateFiles($element["PROPS"]["FILES"]["VALUE"]);
               }

               //совместимые товары
               self::updateAttachedItems($element["PROPS"]["ATTACHED_ITEMS"]["VALUE"]);

                //____________________________Управление с радиопультов
               // объект управления
               self::updateControlObject($element["PROPS"]["T34_CONTROLL_OBJECT"]["VALUE_ENUM_ID"]);

               //способ монтажа
               self::updateInstallType($element["PROPS"]["T34_INSTALL_TYPE"]["VALUE_ENUM_ID"]);

               //установка на улице
               if($element["PROPS"]["T34_OUTDOOR_INSTALL"]["VALUE"] == "Да") {
                   self::updateOutdoorInstall("Y");
               } else {
                   self::updateOutdoorInstall("N");
               }

               //Количество групп управления
               self::updateControlGroupQnt($element["PROPS"]["T33_CONTROL_GROUP_QNT"]["VALUE_ENUM_ID"]);

                //формфактор
                self::updateFormfactor1($element["PROPS"]["T33_FORMFACTOR_1"]["VALUE_ENUM_ID"]);


                //поддержка сценариев
                if($element["PROPS"]["T33_SCRIPT_SUPPORT"]["VALUE"] == "Да") {
                    self::updateScriptSupport("Y");
                } else {
                    self::updateScriptSupport("N");
                }

                //функция таймера
                if($element["PROPS"]["T33_TIMER_FUNCTION"]["VALUE"] == "Да") {
                    self::updateTimerFunction("Y");
                } else {
                    self::updateTimerFunction("N");
                }

                //вал
                self::updateVal($element["PROPS"]["T36_VAL"]["VALUE_ENUM_ID"]);

                //наличие радиоуправления
                self::updateRadiocontrol($element["PROPS"]["T36_RADIOCONTROL"]["VALUE_ENUM_ID"]);

                //________________________Управление с пультов PLC
                //Объект управления
                self::updateControlObject2($element["PROPS"]["T40_CONTROLL_OBJECT_2"]["VALUE_ENUM_ID"]);
                //Способ монтажа
                self::updateInstallType2($element["PROPS"]["T40_INSTALL_TYPE_2"]["VALUE_ENUM_ID"]);
                //Формфактор
                self::updateFormfactor2($element["PROPS"]["T39_FORMFACTOR_2"]["VALUE_ENUM_ID"]);
                //Количество групп управления
                self::updateControlGroupQnt2($element["PROPS"]["T39_CONTROL_GROUP_QNT_2"]["VALUE_ENUM_ID"]);

                //поддержка сценариев
                if($element["PROPS"]["T39_SCRIPT_SUPPORT_2"]["VALUE"] == "Y") {
                    self::updateScriptSupport2("Y");
                } else {
                    self::updateScriptSupport2("N");
                }

                //функция таймера
                if($element["PROPS"]["T39_TIMER_FUNCTION_2"]["VALUE"] == "Y") {
                    self::updateTimerFunction2("Y");
                } else {
                    self::updateTimerFunction2("N");
                }

                //_____________________Управление с электронных ключей
                //Количество карт в комплекте
                self::updateComplectQnt($element["PROPS"]["T42_COMPLECT_QNT"]["VALUE_ENUM_ID"]);
                //Комплектность
                self::updateComplect($element["PROPS"]["T42_COMPLECT"]["VALUE_ENUM_ID"]);
                //Тип управления
                self::updateControlType($element["PROPS"]["T43_CONTROL_TYPE"]["VALUE_ENUM_ID"]);

                //_____________________Управление с механических выключателей
                //Тип выключателя
                self::updateVyklType($element["PROPS"]["VYKL_TYPE"]["VALUE_ENUM_ID"]);
                //Количество точек управления роллетой
                self::updateControlPointQnt($element["PROPS"]["CONTROL_POINT_QNT"]["VALUE_ENUM_ID"]);

                //цены
                self::updatePrice($element["PROPS"]);


            }
            //exit;
        }
    }

    public static function get_element($element_id, $iblock_id) {
        $arSelect = Array();
        $arFilter = Array("IBLOCK_ID" => $iblock_id, "ID" => $element_id, "ACTIVE"=>"Y");


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

    public static function get_sibling($iblock_id, $name, $section = "") {
        $arSelect = Array();
        $arFilter = Array("IBLOCK_ID" => $iblock_id, "NAME" => $name, "ACTIVE"=>"Y");
        if($section) {
            $arFilter["SECTION_CODE"] = $section;
        }


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

    public static function get_sibling_section_id($iblock_id, $section_code) {
        $arFilter = array('IBLOCK_ID' => $iblock_id, "DEPTH_LEVEL" => 1, "CODE" => $section_code);
        $rsSect = CIBlockSection::GetList(Array("ID"=>"ASC"), $arFilter);

        $sections = array();

        while ($arSect = $rsSect->GetNext())
        {
            $sections = $arSect;
        }

        return $sections["ID"];
    }

    public static function create_sibling($iblock_id, $iblock_section_id, $name) {
        $e = new CIBlockElement;
        $arLoadProductArray = array(
            "IBLOCK_ID"      => $iblock_id,
            "IBLOCK_SECTION_ID" => $iblock_section_id,
            "NAME" => $name,
            "CODE" => Cutil::translit($name,"ru", array("replace_space"=>"-","replace_other"=>"-"))
        );


        if($PRODUCT_ID = $e->Add($arLoadProductArray)) {
            CCatalogProduct::add(array("ID" => $PRODUCT_ID, "QUANTITY" => 0, "WEIGHT" =>0));
            return $PRODUCT_ID;
        } else {
            return $e->LAST_ERROR;
        }
    }

    public static function get_section($iblock_id, $section_id) {
        $arFilter = array('IBLOCK_ID' => $iblock_id, "DEPTH_LEVEL" => 1, "ID" => $section_id);
        $rsSect = CIBlockSection::GetList(Array("ID"=>"ASC"), $arFilter);

        $sections = array();

        while ($arSect = $rsSect->GetNext())
        {
            $sections[] = $arSect;
        }

        return $sections;
    }

    public static function updateType($id) {
        $types = array(
            58 => array(
                33 => 179,
                34 => 180,
                36 => 181,
                39 => 182,
                40 => 183,
                41 => 184,
                178 => 185,
                42 => 186,
                35 => 187,
                43 => 188,
                44 => 189,
                45 => 190,
                46 => 191,
            ),
            59 => array(
                33 => 262,
                34 => 263,
                36 => 264,
                39 => 265,
                40 => 266,
                41 => 267,
                178 => 268,
                42 => 269,
                35 => 270,
                43 => 271,
                44 => 272,
                45 => 273,
                46 => 274,
            ),
            60 => array(
                33 => 345,
                34 => 346,
                36 => 347,
                39 => 348,
                40 => 349,
                41 => 350,
                178 => 351,
                42 => 352,
                35 => 353,
                43 => 354,
                44 => 355,
                45 => 356,
                46 => 357,
            ),
        );
        CIBlockElement::SetPropertyValueCode(self::$current_sibling, "type", $types[self::$current_sibling_iblock][$id]);
    }

    public static function updateLine($id) {
        $lines = array(
            58 => array(
                37 => 192,
                38 => 193,
                62 => 194,
                63 => 195,
                64 => 196,
            ),
            59 => array(
                37 => 275,
                38 => 276,
                62 => 277,
                63 => 278,
                64 => 279,
            ),
            60 => array(
                37 => 358,
                38 => 359,
                62 => 360,
                63 => 361,
                64 => 362,
            )
        );
        CIBlockElement::SetPropertyValueCode(self::$current_sibling, "line", $lines[self::$current_sibling_iblock][$id]);
    }

    public static function updateColorCode($value) {
        CIBlockElement::SetPropertyValueCode(self::$current_sibling, "COLOR_CODE", $value);
    }

    public static function updateColorCodeCml($value) {
        CIBlockElement::SetPropertyValueCode(self::$current_sibling_cml, "COLOR_CODE", $value);
    }

    public static function updatePreviewPicture($id) {

        $el = new CIBlockElement;

        $arLoadProductArray = Array(
            "PREVIEW_PICTURE"   => CFile::MakeFileArray($id),
        );

        $PRODUCT_ID = self::$current_sibling;
        $res = $el->Update($PRODUCT_ID, $arLoadProductArray);
    }

    public static function updatePreviewPictureCml($id) {

        $el = new CIBlockElement;

        $arLoadProductArray = Array(
            "PREVIEW_PICTURE"   => CFile::MakeFileArray($id),
        );

        $PRODUCT_ID = self::$current_sibling_cml;
        $res = $el->Update($PRODUCT_ID, $arLoadProductArray);
    }

    public static function updateDetailPicture($id) {

        $el = new CIBlockElement;

        $arLoadProductArray = Array(
            "DETAIL_PICTURE"   => CFile::MakeFileArray($id),
        );

        $PRODUCT_ID = self::$current_sibling;
        $res = $el->Update($PRODUCT_ID, $arLoadProductArray);
    }

    public static function updateDetailPictureCml($id) {

        $el = new CIBlockElement;

        $arLoadProductArray = Array(
            "DETAIL_PICTURE"   => CFile::MakeFileArray($id),
        );

        $PRODUCT_ID = self::$current_sibling_cml;
        $res = $el->Update($PRODUCT_ID, $arLoadProductArray);
    }

    public static function updatePreviewText($txt) {
        $el = new CIBlockElement;

        $arLoadProductArray = Array(
            "PREVIEW_TEXT"   => $txt,
        );

        $PRODUCT_ID = self::$current_sibling;
        $res = $el->Update($PRODUCT_ID, $arLoadProductArray);
    }

    public static function updateDetailText($txt) {
        $el = new CIBlockElement;

        $arLoadProductArray = Array(
            "DETAIL_TEXT"   => $txt,
        );

        $PRODUCT_ID = self::$current_sibling;
        $res = $el->Update($PRODUCT_ID, $arLoadProductArray);
    }

    public static function updateActionLength($value) {
        CIBlockElement::SetPropertyValueCode(self::$current_sibling, "ACTION_LENGTH", $value);
    }

    public static function updateMoreIcons($array) {
    //обнуляем значение свойства - иначе файлы добавляются (дублируются)
        CIBlockElement::SetPropertyValuesEx(
            self::$current_sibling,
            self::$current_sibling_iblock,
            array('MORE_ICONS' => array('VALUE' => array()))
        );

        //сохраняем файлы в свойство
        $arFile = array();
        foreach($array as $id) {
            $arFile[] = array("VALUE" => CFile::MakeFileArray($id), "DESCRIPTION"=>"");
        }

        CIBlockElement::SetPropertyValueCode(self::$current_sibling, "MORE_ICONS", $arFile);
    }

    public static function updateMorePhoto($array) {

        //обнуляем значение свойства - иначе файлы добавляются (дублируются)
        CIBlockElement::SetPropertyValuesEx(
            self::$current_sibling,
            self::$current_sibling_iblock,
            array('MORE_PHOTO' => array('VALUE' => array()))
        );

        //сохраняем файлы в свойство
        $arFile = array();
        foreach($array as $id) {
            $arFile[] = array("VALUE" => CFile::MakeFileArray($id), "DESCRIPTION"=>"");
        }

        CIBlockElement::SetPropertyValueCode(self::$current_sibling, "MORE_PHOTO", $arFile);
    }

    public static function updateMorePhotoCml($array) {

        //обнуляем значение свойства - иначе файлы добавляются (дублируются)
        CIBlockElement::SetPropertyValuesEx(
            self::$current_sibling_cml,
            self::$current_sibling_cml_iblock,
            array('MORE_PHOTO' => array('VALUE' => array()))
        );

        //сохраняем файлы в свойство
        $arFile = array();
        foreach($array as $id) {
            $arFile[] = array("VALUE" => CFile::MakeFileArray($id), "DESCRIPTION"=>"");
        }

        CIBlockElement::SetPropertyValueCode(self::$current_sibling_cml, "MORE_PHOTO", $arFile);
    }

    public static function updateOsobennosty($value) {
        CIBlockElement::SetPropertyValueCode(self::$current_sibling, "OSOBENNOSTY", $value);
    }

    public static function updateHaracteristiky($value) {
        CIBlockElement::SetPropertyValueCode(self::$current_sibling, "HARACTERISTIKY", $value);
    }

    public static function updateHaracteristikyHtml($value) {
        CIBlockElement::SetPropertyValueCode(self::$current_sibling, "HARACTERISTIKY_HTML", array('VALUE'=>array('TYPE'=>'html', 'TEXT'=>$value)));
    }

    public static function updateInstalling($value) {
        CIBlockElement::SetPropertyValueCode(self::$current_sibling, "INSTALLING", array('VALUE'=>array('TYPE'=>'html', 'TEXT'=>$value)));
    }

    public static function updateControllHtml($value) {
        CIBlockElement::SetPropertyValueCode(self::$current_sibling, "CONTROLL_HTML", array('VALUE'=>array('TYPE'=>'html', 'TEXT'=>$value)));
    }

    public static function updateControllImg($id) {
        //обнуляем значение свойства - иначе файлы добавляются (дублируются)
        CIBlockElement::SetPropertyValuesEx(
            self::$current_sibling,
            self::$current_sibling_iblock,
            array('CONTROLL_IMG' => array('VALUE' => array()))
        );

        //сохраняем файлы в свойство
        $arFile = array();
        $arFile[] = array("VALUE" => CFile::MakeFileArray($id), "DESCRIPTION"=>"");

        CIBlockElement::SetPropertyValueCode(self::$current_sibling, "CONTROLL_IMG", $arFile);
    }

    public static function updateFiles($value) {
        CIBlockElement::SetPropertyValueCode(self::$current_sibling, "FILES", $value);
    }

    public static function updateAttachedItems($array) {
        $items = array();

        foreach($array as $id) {
            $el = self::get_element($id, 30);
            if($el) {
                $sib_attached = self::get_sibling(self::$current_sibling_iblock, $el["NAME"], self::$section_code);
                if($sib_attached) {
                    $items[] = $sib_attached["ID"];
                }
            }
        }

        if($items) {
            CIBlockElement::SetPropertyValueCode(self::$current_sibling, "ATTACHED_ITEMS", $items);
        }
    }

    public static function updateControlObject($array) {
        $property_codes = array(
            58 => "T180_CONTROLL_OBJECT",
            59 => "T263_CONTROLL_OBJECT",
            60 => "T346_CONTROLL_OBJECT"
        );

        $siblings_ids = array();
        $main_ids = array();

        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>30, "CODE"=>"T34_CONTROLL_OBJECT"));
        while ($enum_fields = $property_enums->GetNext()) {
            $main_ids[] = $enum_fields["ID"];
        }


        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>self::$current_sibling_iblock, "CODE"=>$property_codes[self::$current_sibling_iblock]));
        while ($enum_fields = $property_enums->GetNext()) {
            $siblings_ids[] = $enum_fields["ID"];
        }

        $ids_to_update = array();

        foreach($main_ids as $i => $id) {
            if(in_array($id, $array)) {
                $ids_to_update[] = $siblings_ids[$i];
            }
        }

        CIBlockElement::SetPropertyValueCode(self::$current_sibling, $property_codes[self::$current_sibling_iblock], $ids_to_update);
    }

    public static function updateInstallType($array) {
        $property_codes = array(
            58 => "T180_INSTALL_TYPE",
            59 => "T263_INSTALL_TYPE",
            60 => "T346_INSTALL_TYPE"
        );

        $siblings_ids = array();
        $main_ids = array();

        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>30, "CODE"=>"T34_INSTALL_TYPE"));
        while ($enum_fields = $property_enums->GetNext()) {
            $main_ids[] = $enum_fields["ID"];
        }


        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>self::$current_sibling_iblock, "CODE"=>$property_codes[self::$current_sibling_iblock]));
        while ($enum_fields = $property_enums->GetNext()) {
            $siblings_ids[] = $enum_fields["ID"];
        }

        $ids_to_update = array();

        foreach($main_ids as $i => $id) {
            if(in_array($id, $array)) {
                $ids_to_update[] = $siblings_ids[$i];
            }
        }

        CIBlockElement::SetPropertyValueCode(self::$current_sibling, $property_codes[self::$current_sibling_iblock], $ids_to_update);
    }

    public static function updateOutdoorInstall($value) {
        $property_codes = array(
            58 => array("CODE"=> "T180_OUTDOOR_INSTALL", "VALUE" =>209),
            59 => array("CODE"=> "T263_OUTDOOR_INSTALL", "VALUE" =>292),
            60 => array("CODE"=> "T346_OUTDOOR_INSTALL", "VALUE" =>375),
        );

        CIBlockElement::SetPropertyValueCode(self::$current_sibling, $property_codes[self::$current_sibling_iblock]["CODE"], ($value == "Y")? $property_codes[self::$current_sibling_iblock]["VALUE"] : 0);
    }

    public static function updateControlGroupQnt($array) {
        $property_codes = array(
            58 => "T179_CONTROL_GROUP_QNT",
            59 => "T262_CONTROL_GROUP_QNT",
            60 => "T345_CONTROL_GROUP_QNT"
        );

        $siblings_ids = array();
        $main_ids = array();

        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>30, "CODE"=>"T33_CONTROL_GROUP_QNT"));
        while ($enum_fields = $property_enums->GetNext()) {
            $main_ids[] = $enum_fields["ID"];
        }


        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>self::$current_sibling_iblock, "CODE"=>$property_codes[self::$current_sibling_iblock]));
        while ($enum_fields = $property_enums->GetNext()) {
            $siblings_ids[] = $enum_fields["ID"];
        }

        $ids_to_update = array();

        foreach($main_ids as $i => $id) {
            if(in_array($id, $array)) {
                $ids_to_update[] = $siblings_ids[$i];
            }
        }

        CIBlockElement::SetPropertyValueCode(self::$current_sibling, $property_codes[self::$current_sibling_iblock], $ids_to_update);
    }

    public static function updateFormfactor1($array) {
        $property_codes = array(
            58 => "T179_FORMFACTOR_1",
            59 => "T262_FORMFACTOR_1",
            60 => "T345_FORMFACTOR_1"
        );

        $siblings_ids = array();
        $main_ids = array();

        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>30, "CODE"=>"T33_FORMFACTOR_1"));
        while ($enum_fields = $property_enums->GetNext()) {
            $main_ids[] = $enum_fields["ID"];
        }


        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>self::$current_sibling_iblock, "CODE"=>$property_codes[self::$current_sibling_iblock]));
        while ($enum_fields = $property_enums->GetNext()) {
            $siblings_ids[] = $enum_fields["ID"];
        }

        $ids_to_update = array();

        foreach($main_ids as $i => $id) {
            if(in_array($id, $array)) {
                $ids_to_update[] = $siblings_ids[$i];
            }
        }

        CIBlockElement::SetPropertyValueCode(self::$current_sibling, $property_codes[self::$current_sibling_iblock], $ids_to_update);
    }

    public static function updateScriptSupport($value) {
        $property_codes = array(
            58 => array("CODE"=> "T179_SCRIPT_SUPPORT", "VALUE" =>225),
            59 => array("CODE"=> "T262_SCRIPT_SUPPORT", "VALUE" =>308),
            60 => array("CODE"=> "T345_SCRIPT_SUPPORT", "VALUE" =>391),
        );

        CIBlockElement::SetPropertyValueCode(self::$current_sibling, $property_codes[self::$current_sibling_iblock]["CODE"], ($value == "Y")? $property_codes[self::$current_sibling_iblock]["VALUE"] : 0);
    }

    public static function updateTimerFunction($value) {
        $property_codes = array(
            58 => array("CODE"=> "T179_TIMER_FUNCTION", "VALUE" =>226),
            59 => array("CODE"=> "T262_TIMER_FUNCTION", "VALUE" =>309),
            60 => array("CODE"=> "T345_TIMER_FUNCTION", "VALUE" =>392),
        );

        CIBlockElement::SetPropertyValueCode(self::$current_sibling, $property_codes[self::$current_sibling_iblock]["CODE"], ($value == "Y")? $property_codes[self::$current_sibling_iblock]["VALUE"] : 0);
    }

    public static function updateVal($array) {
        $property_codes = array(
            58 => "T181_VAL",
            59 => "T264_VAL",
            60 => "T347_VAL"
        );

        $siblings_ids = array();
        $main_ids = array();

        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>30, "CODE"=>"T36_VAL"));
        while ($enum_fields = $property_enums->GetNext()) {
            $main_ids[] = $enum_fields["ID"];
        }


        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>self::$current_sibling_iblock, "CODE"=>$property_codes[self::$current_sibling_iblock]));
        while ($enum_fields = $property_enums->GetNext()) {
            $siblings_ids[] = $enum_fields["ID"];
        }

        $ids_to_update = array();

        foreach($main_ids as $i => $id) {
            if(in_array($id, $array)) {
                $ids_to_update[] = $siblings_ids[$i];
            }
        }

        CIBlockElement::SetPropertyValueCode(self::$current_sibling, $property_codes[self::$current_sibling_iblock], $ids_to_update);
    }

    public static function updateRadiocontrol($array) {
        $property_codes = array(
            58 => "T181_RADIOCONTROL",
            59 => "T264_RADIOCONTROL",
            60 => "T347_RADIOCONTROL"
        );

        $siblings_ids = array();
        $main_ids = array();

        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>30, "CODE"=>"T36_RADIOCONTROL"));
        while ($enum_fields = $property_enums->GetNext()) {
            $main_ids[] = $enum_fields["ID"];
        }


        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>self::$current_sibling_iblock, "CODE"=>$property_codes[self::$current_sibling_iblock]));
        while ($enum_fields = $property_enums->GetNext()) {
            $siblings_ids[] = $enum_fields["ID"];
        }

        $ids_to_update = array();

        foreach($main_ids as $i => $id) {
            if(in_array($id, $array)) {
                $ids_to_update[] = $siblings_ids[$i];
            }
        }

        CIBlockElement::SetPropertyValueCode(self::$current_sibling, $property_codes[self::$current_sibling_iblock], $ids_to_update);
    }

    public static function updateControlObject2($array) {
        $property_codes = array(
            58 => "T183_CONTROLL_OBJECT_2",
            59 => "T266_CONTROLL_OBJECT_2",
            60 => "T349_CONTROLL_OBJECT_2"
        );

        $siblings_ids = array();
        $main_ids = array();

        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>30, "CODE"=>"T40_CONTROLL_OBJECT_2"));
        while ($enum_fields = $property_enums->GetNext()) {
            $main_ids[] = $enum_fields["ID"];
        }


        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>self::$current_sibling_iblock, "CODE"=>$property_codes[self::$current_sibling_iblock]));
        while ($enum_fields = $property_enums->GetNext()) {
            $siblings_ids[] = $enum_fields["ID"];
        }

        $ids_to_update = array();

        foreach($main_ids as $i => $id) {
            if(in_array($id, $array)) {
                $ids_to_update[] = $siblings_ids[$i];
            }
        }

        CIBlockElement::SetPropertyValueCode(self::$current_sibling, $property_codes[self::$current_sibling_iblock], $ids_to_update);
    }


    public static function updateInstallType2($array) {
        $property_codes = array(
            58 => "T183_INSTALL_TYPE_2",
            59 => "T266_INSTALL_TYPE_2",
            60 => "T349_INSTALL_TYPE_2"
        );

        $siblings_ids = array();
        $main_ids = array();

        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>30, "CODE"=>"T40_INSTALL_TYPE_2"));
        while ($enum_fields = $property_enums->GetNext()) {
            $main_ids[] = $enum_fields["ID"];
        }


        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>self::$current_sibling_iblock, "CODE"=>$property_codes[self::$current_sibling_iblock]));
        while ($enum_fields = $property_enums->GetNext()) {
            $siblings_ids[] = $enum_fields["ID"];
        }

        $ids_to_update = array();

        foreach($main_ids as $i => $id) {
            if(in_array($id, $array)) {
                $ids_to_update[] = $siblings_ids[$i];
            }
        }

        CIBlockElement::SetPropertyValueCode(self::$current_sibling, $property_codes[self::$current_sibling_iblock], $ids_to_update);
    }

    public static function updateFormfactor2($array) {
        $property_codes = array(
            58 => "T182_FORMFACTOR_2",
            59 => "T265_FORMFACTOR_2",
            60 => "T348_FORMFACTOR_2"
        );

        $siblings_ids = array();
        $main_ids = array();

        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>30, "CODE"=>"T39_FORMFACTOR_2"));
        while ($enum_fields = $property_enums->GetNext()) {
            $main_ids[] = $enum_fields["ID"];
        }


        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>self::$current_sibling_iblock, "CODE"=>$property_codes[self::$current_sibling_iblock]));
        while ($enum_fields = $property_enums->GetNext()) {
            $siblings_ids[] = $enum_fields["ID"];
        }

        $ids_to_update = array();

        foreach($main_ids as $i => $id) {
            if(in_array($id, $array)) {
                $ids_to_update[] = $siblings_ids[$i];
            }
        }

        CIBlockElement::SetPropertyValueCode(self::$current_sibling, $property_codes[self::$current_sibling_iblock], $ids_to_update);
    }

    public static function updateControlGroupQnt2($array) {
        $property_codes = array(
            58 => "T182_CONTROL_GROUP_QNT_2",
            59 => "T265_CONTROL_GROUP_QNT_2",
            60 => "T348_CONTROL_GROUP_QNT_2"
        );

        $siblings_ids = array();
        $main_ids = array();

        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>30, "CODE"=>"T39_CONTROL_GROUP_QNT_2"));
        while ($enum_fields = $property_enums->GetNext()) {
            $main_ids[] = $enum_fields["ID"];
        }


        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>self::$current_sibling_iblock, "CODE"=>$property_codes[self::$current_sibling_iblock]));
        while ($enum_fields = $property_enums->GetNext()) {
            $siblings_ids[] = $enum_fields["ID"];
        }

        $ids_to_update = array();

        foreach($main_ids as $i => $id) {
            if(in_array($id, $array)) {
                $ids_to_update[] = $siblings_ids[$i];
            }
        }

        CIBlockElement::SetPropertyValueCode(self::$current_sibling, $property_codes[self::$current_sibling_iblock], $ids_to_update);
    }

    public static function updateScriptSupport2($value) {
        $property_codes = array(
            58 => array("CODE"=> "T182_SCRIPT_SUPPORT_2", "VALUE" =>249),
            59 => array("CODE"=> "T265_SCRIPT_SUPPORT_2", "VALUE" =>332),
            60 => array("CODE"=> "T348_SCRIPT_SUPPORT_2", "VALUE" =>415),
        );

        CIBlockElement::SetPropertyValueCode(self::$current_sibling, $property_codes[self::$current_sibling_iblock]["CODE"], ($value == "Y")? $property_codes[self::$current_sibling_iblock]["VALUE"] : 0);
    }

    public static function updateTimerFunction2($value) {
        $property_codes = array(
            58 => array("CODE"=> "T182_TIMER_FUNCTION_2", "VALUE" =>250),
            59 => array("CODE"=> "T265_TIMER_FUNCTION_2", "VALUE" =>333),
            60 => array("CODE"=> "T348_TIMER_FUNCTION_2", "VALUE" =>416),
        );

        CIBlockElement::SetPropertyValueCode(self::$current_sibling, $property_codes[self::$current_sibling_iblock]["CODE"], ($value == "Y")? $property_codes[self::$current_sibling_iblock]["VALUE"] : 0);
    }

    public static function updateComplectQnt($array) {
        $property_codes = array(
            58 => "T186_COMPLECT_QNT",
            59 => "T269_COMPLECT_QNT",
            60 => "T352_COMPLECT_QNT"
        );

        $siblings_ids = array();
        $main_ids = array();

        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>30, "CODE"=>"T42_COMPLECT_QNT"));
        while ($enum_fields = $property_enums->GetNext()) {
            $main_ids[] = $enum_fields["ID"];
        }


        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>self::$current_sibling_iblock, "CODE"=>$property_codes[self::$current_sibling_iblock]));
        while ($enum_fields = $property_enums->GetNext()) {
            $siblings_ids[] = $enum_fields["ID"];
        }

        $ids_to_update = array();

        foreach($main_ids as $i => $id) {
            if(in_array($id, $array)) {
                $ids_to_update[] = $siblings_ids[$i];
            }
        }

        CIBlockElement::SetPropertyValueCode(self::$current_sibling, $property_codes[self::$current_sibling_iblock], $ids_to_update);
    }

    public static function updateComplect($array) {
        $property_codes = array(
            58 => "T186_COMPLECT",
            59 => "T269_COMPLECT",
            60 => "T352_COMPLECT"
        );

        $siblings_ids = array();
        $main_ids = array();

        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>30, "CODE"=>"T42_COMPLECT"));
        while ($enum_fields = $property_enums->GetNext()) {
            $main_ids[] = $enum_fields["ID"];
        }


        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>self::$current_sibling_iblock, "CODE"=>$property_codes[self::$current_sibling_iblock]));
        while ($enum_fields = $property_enums->GetNext()) {
            $siblings_ids[] = $enum_fields["ID"];
        }

        $ids_to_update = array();

        foreach($main_ids as $i => $id) {
            if(in_array($id, $array)) {
                $ids_to_update[] = $siblings_ids[$i];
            }
        }

        CIBlockElement::SetPropertyValueCode(self::$current_sibling, $property_codes[self::$current_sibling_iblock], $ids_to_update);
    }

    public static function updateControlType($array) {
        $property_codes = array(
            58 => "T188_CONTROL_TYPE",
            59 => "T271_CONTROL_TYPE",
            60 => "T354_CONTROL_TYPE"
        );

        $siblings_ids = array();
        $main_ids = array();

        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>30, "CODE"=>"T43_CONTROL_TYPE"));
        while ($enum_fields = $property_enums->GetNext()) {
            $main_ids[] = $enum_fields["ID"];
        }


        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>self::$current_sibling_iblock, "CODE"=>$property_codes[self::$current_sibling_iblock]));
        while ($enum_fields = $property_enums->GetNext()) {
            $siblings_ids[] = $enum_fields["ID"];
        }

        $ids_to_update = array();

        foreach($main_ids as $i => $id) {
            if(in_array($id, $array)) {
                $ids_to_update[] = $siblings_ids[$i];
            }
        }

        CIBlockElement::SetPropertyValueCode(self::$current_sibling, $property_codes[self::$current_sibling_iblock], $ids_to_update);
    }

    public static function updateVyklType($array) {
        $property_codes = array(
            58 => "VYKL_TYPE",
            59 => "VYKL_TYPE",
            60 => "VYKL_TYPE"
        );

        $siblings_ids = array();
        $main_ids = array();

        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>30, "CODE"=>"VYKL_TYPE"));
        while ($enum_fields = $property_enums->GetNext()) {
            $main_ids[] = $enum_fields["ID"];
        }


        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>self::$current_sibling_iblock, "CODE"=>$property_codes[self::$current_sibling_iblock]));
        while ($enum_fields = $property_enums->GetNext()) {
            $siblings_ids[] = $enum_fields["ID"];
        }

        $ids_to_update = array();

        foreach($main_ids as $i => $id) {
            if(in_array($id, $array)) {
                $ids_to_update[] = $siblings_ids[$i];
            }
        }

        CIBlockElement::SetPropertyValueCode(self::$current_sibling, $property_codes[self::$current_sibling_iblock], $ids_to_update);
    }

    public static function updateControlPointQnt($array) {
        $property_codes = array(
            58 => "CONTROL_POINT_QNT",
            59 => "CONTROL_POINT_QNT",
            60 => "CONTROL_POINT_QNT"
        );

        $siblings_ids = array();
        $main_ids = array();

        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>30, "CODE"=>"CONTROL_POINT_QNT"));
        while ($enum_fields = $property_enums->GetNext()) {
            $main_ids[] = $enum_fields["ID"];
        }


        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>self::$current_sibling_iblock, "CODE"=>$property_codes[self::$current_sibling_iblock]));
        while ($enum_fields = $property_enums->GetNext()) {
            $siblings_ids[] = $enum_fields["ID"];
        }

        $ids_to_update = array();

        foreach($main_ids as $i => $id) {
            if(in_array($id, $array)) {
                $ids_to_update[] = $siblings_ids[$i];
            }
        }

        CIBlockElement::SetPropertyValueCode(self::$current_sibling, $property_codes[self::$current_sibling_iblock], $ids_to_update);
    }

    public static function updatePrice($array) {

        $price = 0;
        switch(self::$current_sibling_iblock) {
            case 58: $price = $array["PRICE_UA"]["VALUE"];
                break;
            case 59: $price = $array["PRICE_SP"]["VALUE"];
                break;
            case 60: $price = $array["PRICE_MSK"]["VALUE"];
        }

        $arFields = Array(
            "PRODUCT_ID" => self::$current_sibling,
            "CATALOG_GROUP_ID" => 1,
            "PRICE" => $price,
            "CURRENCY" => "EUR",
        );


        $res = CPrice::GetList(array(), array(
                "PRODUCT_ID" => self::$current_sibling,
                "CATALOG_GROUP_ID" => 1
            )
        );

        if ($arr = $res->Fetch()){

            CPrice::Update($arr["ID"], $arFields, true);
        } else {
            CPrice::Add($arFields);
        }
    }

    public static function updatePriceCml($array) {

        $price = 0;
        switch(self::$current_sibling_cml_iblock) {
            case 63: $price = $array["PRICE_UA"]["VALUE"];
                break;
            case 61: $price = $array["PRICE_SP"]["VALUE"];
                break;
            case 62: $price = $array["PRICE_MSK"]["VALUE"];
        }

        $arFields = Array(
            "PRODUCT_ID" => self::$current_sibling_cml,
            "CATALOG_GROUP_ID" => 1,
            "PRICE" => $price,
            "CURRENCY" => "EUR",
        );


        $res = CPrice::GetList(array(), array(
                "PRODUCT_ID" => self::$current_sibling_cml,
                "CATALOG_GROUP_ID" => 1
            )
        );

        if ($arr = $res->Fetch()){

            CPrice::Update($arr["ID"], $arFields, true);
        } else {
            CPrice::Add($arFields);
        }
    }

    public static function updateParentProduct($id) {
        if($id) {
            $product = self::get_element($id, 30);

            $product_iblock_id = 0;
            //echo self::$current_sibling_cml_iblock; exit;
            foreach(self::$offers_ib as $key=>$i) {
                if($i == self::$current_sibling_cml_iblock ) {
                    $product_iblock_id = self::$iblocks[$key];
                }
            }

            $el = self::get_sibling($product_iblock_id, $product["NAME"]);

            if($el) {
                CIBlockElement::SetPropertyValueCode(self::$current_sibling_cml, "CML2_LINK", $el["ID"]);
            }
        }
    }

















}
