<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
if(!function_exists('getFilterProperties')){
    function getFilterProperties($iblock_id, $section_id)
    {
        $component = new CBitrixComponent();
        $component->InitComponent('bitrix:catalog.smart.filter');
        $component->InitComponent('bitrix:catalog.smart.filter');
        $filter = new CBitrixCatalogSmartFilter($component);
        $filter->IBLOCK_ID = $iblock_id;
        $filter->SECTION_ID = $section_id;
        $filter->facet = new \Bitrix\Iblock\PropertyIndex\Facet($filter->IBLOCK_ID);
        $items = $filter->getResultItems();
        foreach ($items as $key => $item){
            $filter->facet->setSectionId($filter->SECTION_ID);
            $arResult["FACET_FILTER"] = array(
                "ACTIVE_DATE" => "Y",
                "CHECK_PERMISSIONS" => "Y",
            );
            if ($filter->arParams['HIDE_NOT_AVAILABLE'] == 'Y')
                $arResult["FACET_FILTER"]['CATALOG_AVAILABLE'] = 'Y';

            $res = $filter->facet->query($arResult["FACET_FILTER"]);
            CTimeZone::Disable();
            while ($row = $res->fetch())
            {
                $facetId = $row["FACET_ID"];
                if (\Bitrix\Iblock\PropertyIndex\Storage::isPropertyId($facetId))
                {
                    $PID = \Bitrix\Iblock\PropertyIndex\Storage::facetIdToPropertyId($facetId);
                    if ($items[$PID]["PROPERTY_TYPE"] == "N")
                    {
                        $filter->fillItemValues($items[$PID], $row["MIN_VALUE_NUM"]);
                        $filter->fillItemValues($items[$PID], $row["MAX_VALUE_NUM"]);
                        if ($row["VALUE_FRAC_LEN"] > 0)
                            $items[$PID]["DECIMALS"] = $row["VALUE_FRAC_LEN"];
                    }
                    elseif ($items[$PID]["DISPLAY_TYPE"] == "U")
                    {
                        $filter->fillItemValues($items[$PID], FormatDate("Y-m-d", $row["MIN_VALUE_NUM"]));
                        $filter->fillItemValues($items[$PID], FormatDate("Y-m-d", $row["MAX_VALUE_NUM"]));
                    }
                    elseif ($items[$PID]["PROPERTY_TYPE"] == "S")
                    {
                        $addedKey = $filter->fillItemValues($items[$PID], $filter->facet->lookupDictionaryValue($row["VALUE"]), true);
                        if (strlen($addedKey) > 0)
                        {
                            $items[$PID]["VALUES"][$addedKey]["FACET_VALUE"] = $row["VALUE"];
                            $items[$PID]["VALUES"][$addedKey]["ELEMENT_COUNT"] = $row["ELEMENT_COUNT"];
                        }
                    }
                    else
                    {
                        $addedKey = $filter->fillItemValues($items[$PID], $row["VALUE"], true);
                        if (strlen($addedKey) > 0)
                        {
                            $items[$PID]["VALUES"][$addedKey]["FACET_VALUE"] = $row["VALUE"];
                            $items[$PID]["VALUES"][$addedKey]["ELEMENT_COUNT"] = $row["ELEMENT_COUNT"];
                        }
                    }
                }
                else
                {
                    $priceId = \Bitrix\Iblock\PropertyIndex\Storage::facetIdToPriceId($facetId);
                    foreach($arResult["PRICES"] as $NAME => $arPrice)
                    {
                        if ($arPrice["ID"] == $priceId && isset($items[$NAME]))
                        {
                            $filter->fillItemPrices($items[$NAME], $row);

                            if (isset($items[$NAME]["~CURRENCIES"]))
                            {
                                $arResult["CURRENCIES"] += $items[$NAME]["~CURRENCIES"];
                            }

                            if ($row["VALUE_FRAC_LEN"] > 0)
                            {
                                $items[$PID]["DECIMALS"] = $row["VALUE_FRAC_LEN"];
                            }
                        }
                    }
                }
            }
            CTimeZone::Enable();
        }

        foreach ($items as $key => $item){
            $items[$item['CODE']] = $item;
        }
        
        return $items;
    }
}