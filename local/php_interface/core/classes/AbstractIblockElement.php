<?php

namespace Astronim;

use Bitrix\Iblock\PropertyEnumerationTable;
use Bitrix\Main\Application;
use Bitrix\Main\Loader as Loader;
use Bitrix\Iblock\ElementTable as ElementTable;
use Bitrix\Iblock\PropertyTable as PropertyTable;

abstract class AbstractIblockElement
{
    const ERROR_WRONG_ID = 1;
    const ERROR_WRONG_IBLOCK = 2;

    protected static $propertiesInfo;

    protected $id = null;

    protected $fields = [];
    protected $properties = [];
    protected $full_properties = [];


    /**
     * @return int $iblock_id
     */
    abstract public static function getIblockId();

    /**
     * RegisterRequest constructor.
     * @param int $id
     * @throws \Exception
     */
    public function __construct($id)
    {
        Loader::includeModule('iblock');

        //select from existing
        if (($id = (int)$id) > 0) {
            $fields = \CIBlockElement::GetByID($id)->Fetch();
            if (!$fields['ID'])
                Throw new \Exception("Element with ID #{$id} don't exists", self::ERROR_WRONG_ID);
            if ($fields['IBLOCK_ID'] != static::getIblockId())
                Throw new \Exception("ID #{$id} is not element of iblock #" . static::getIblockId(), self::ERROR_WRONG_IBLOCK);

            $this->id = $fields['ID'];
            unset($fields['ID']);
            unset($fields['IBLOCK_ID']);
            $this->fields = $fields;

            $this->fillFields();
            $this->fillProperties();
        }

        //create new
    }


    /**
     *
     * HERE GETTERS AND SETTERS
     *
     */


    /**
     * @return int|null $id
     */
    public function getId()
    {
        return $this->id;
    }


    public function getField($field)
    {
//        $this->checkBeforeGetField($field);

        return $this->fields[$field];
    }

//    abstract protected function checkBeforeGetField($field);

    public function getFields(array $fields)
    {
        $return = [];

        foreach ($fields as $field) {
            $return[$field] = $this->getField($field);
        }

        return $return;
    }


    public function setField($field, $value)
    {
//        $value = $this->checkBeforeSetField($field);

        $this->fields[$field] = $value;
    }

//    abstract protected function checkBeforeSetField($field);

    public function setFields(array $fields)
    {
        $return = [];

        foreach ($fields as $field => $value) {
            $this->setField($field, $value);
        }

        return $return;
    }


    public function getProperty($property)
    {
//        $this->checkBeforeGetField($field);
        if ($this->full_properties[$property]['PROPERTY_TYPE'] == 'L'){
            if(is_array($this->properties[$property])){
                $return = [];
                foreach ($this->properties[$property] as $pvid){
                    $return[$pvid] = $this->full_properties[$property]['VALUES'][$pvid];
                }
                return $return;
            } else {
                return $this->full_properties[$property]['VALUES'][$this->properties[$property]];
            }
        }
        else
            return $this->properties[$property];
    }

    public function getPropertyInfo($property)
    {
        return $this->full_properties[$property];
    }

//    abstract protected function checkBeforeGetField($field);

    public function getProperties(array $properties)
    {
        $return = [];

        foreach ($properties as $property) {
            $return[$property] = $this->getProperty($property);
        }

        return $return;
    }


    public function setProperty($property, $value)
    {
//        $value = $this->checkBeforeGetField($field);

        $this->properties[$property] = $value;
    }

//    abstract protected function checkBeforeSetProperty($field);

    public function setProperties(array $properties)
    {
        $return = [];

        foreach ($properties as $property => $value) {
            $this->setProperty($property, $value);
        }

        return $return;
    }


    public static function getPropertyIdByExternal($code, $value)
    {
        if ($value && ($value = array_search($value, self::getPropertiesInfo()[$code]['VALUES'])) === false) {
            $add_info = var_export(self::getPropertiesInfo()[$code]['VALUES'], true);

            Throw new \Exception("Wrong list value XML_ID passed ({$code} = {$value}), $add_info");
        }

        return $value;
    }

    private static function getPropertiesInfo()
    {
        if (self::$propertiesInfo === null) {
            $rsProperties = \CIBlockProperty::GetList([], ['IBLOCK_ID' => static::getIblockId()]);
            while ($property_array = $rsProperties->GetNext()) {
                if (!self::$propertiesInfo[$property_array['CODE']]) {

                    if ($property_array['PROPERTY_TYPE'] == 'L') {
                        $property_array['VALUES'] = [];
                        $rs = \CIBlockPropertyEnum::GetList([], ['PROPERTY_ID' => $property_array['ID']]);
                        while ($ar = $rs->GetNext()) {
                            $property_array['VALUES'][$ar['ID']] = $ar['XML_ID'];
                        }
                    }

                    self::$propertiesInfo[$property_array['CODE']] = $property_array;

                }
            }
        }

        return self::$propertiesInfo;
    }




    /**
     *
     * HERE ACTIONS
     *
     */

    /**
     * @throws \Exception
     */
    public function save()
    {
        $fields = $this->fields;

        foreach ($fields as $code => &$value) {
            $value = $this->validateField($value, $code);
        }


        $properties = [];
        foreach ($this->properties as $code => $value) {
            //in case list type convert xml_id to enum_value_id
            if (self::getPropertiesInfo()[$code]['PROPERTY_TYPE'] == 'L') {
                if (self::getPropertiesInfo()[$code]['MULTIPLE'] == 'Y') {
                    foreach ($value as &$val) {
                        $val = self::getPropertyIdByExternal($code, $val);
                    }
                } else {
                    $value = self::getPropertyIdByExternal($code, $value);
                }
            }

            $value = $this->validateProperty($value, $code);

            $properties[$code] = $value;
        }

        $fields['PROPERTY_VALUES'] = $properties;
        $fields['IBLOCK_ID'] = self::getIblockId();

        $el = new \CIBlockElement;
        if ($this->id > 0) {
            $result = $el->Update($this->id, $fields);
            if (!$result) {
                Throw new \Exception('Failed to update element: ' . $el->LAST_ERROR);
            }
        } else {
            $this->id = $el->Add($fields);
            if (!$this->id) {
                Throw new \Exception('Failed to add element: ' . $el->LAST_ERROR);
            }
        }
    }

    public function delete()
    {
        $el = new \CIBlockElement;
        if ($this->id > 0) {
            $result = $el->Delete($this->id);
            if (!$result) {
                Throw new \Exception('Failed to update element: ' . $el->LAST_ERROR);
            }
        }
    }


    protected function fillFields()
    {
        $element = \CIBlockElement::GetList([], ['ID' => $this->getId()], false, false, ['ID', 'IBLOCK_ID', 'DETAIL_PAGE_URL'])->GetNext();
        $this->fields['DETAIL_PAGE_URL'] = $element['DETAIL_PAGE_URL'];

        foreach (['PREVIEW_PICTURE', 'DETAIL_PICTURE'] as $code) {
            if ($id = $this->fields[$code]) $this->fields[$code] = \CFile::GetFileArray($id);
        }
    }

    protected function fillProperties()
    {
        $this->properties = [];
        $rs = \CIBlockElement::GetProperty(static::getIblockId(), $this->id);
        while ($ar = $rs->Fetch()) {
            if ($ar['PROPERTY_TYPE'] == 'L') {
                $value = $ar['VALUE'];
                if (empty($ar['VALUES'])) {
                    $ar['VALUES'] = $this->getEnumValues($ar['ID']);
                }
            } else {
                $value = $ar['VALUE'];
            }


            if ($ar['MULTIPLE'] == 'Y') {
                $this->properties[$ar['CODE']][] = $value;
            } else {
                $this->properties[$ar['CODE']] = $value;
            }

            $this->full_properties[$ar['CODE']] = $ar;
        }
    }


    private function validateField($value, $code)
    {
        if (in_array($code, ['NAME', 'PREVIEW_TEXT', 'DETAIL_TEXT']))
            $value = self::clearSting($value);

        return $value;
    }

    private function validateProperty($value, $code)
    {
        return $value;
    }

    private function getEnumValues($pid)
    {
        $values = [];
        $rs = PropertyEnumerationTable::getList([
            'filter' => ['PROPERTY.IBLOCK_ID' => static::getIblockId(), 'PROPERTY_ID' => $pid]
        ]);
        while ($ar = $rs->fetch()) {
            $values[$ar['ID']] = $ar['VALUE'];
        }

        return $values;
    }


    public static function clearSting($str)
    {
        while (true) {
            $decoded = html_entity_decode($str);
            if ($decoded == $str) break;
            else $str = $decoded;
        }

        return (htmlspecialcharsbx(trim($str)));
    }
}