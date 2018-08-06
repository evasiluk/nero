<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arDefaultFilesParam = [
    "PARENT" => "BASE",
    "NAME" => 'Выберите файл',
    "TYPE" => "FILE",
    "REFRESH" => "Y",
    "SORT" => 1000
];
$arDefaultDescriptionParam = [
    "PARENT" => "BASE",
    "NAME" => 'Описание',
    "TYPE" => "STRING",
    "SORT" => 1001
];

$parameters = [
    "FILE_0" => $arDefaultFilesParam,
    "DESCRIPTION_0" => $arDefaultDescriptionParam
];

$last = 0;
do{
    if(!$arCurrentValues["FILE_{$last}"]) break;
} while(++$last);

for($i = 1; $i <= $last; $i++){
    $arDefaultFilesParam['SORT'] += 10;
    $arDefaultDescriptionParam['SORT'] += 10;

    $parameters["FILE_{$i}"] = $arDefaultFilesParam;
    $parameters["DESCRIPTION_{$i}"] = $arDefaultDescriptionParam;

    $parameters["FILE_{$i}"]['NAME'] .= " {$i}";
    $parameters["DESCRIPTION_{$i}"]['NAME'] .= " {$i}";
}

$arComponentParameters = array(
    "GROUPS" => array(
    ),
    "PARAMETERS" => $parameters
);