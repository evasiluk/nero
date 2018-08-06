<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("test");
?><?
CModule::IncludeModule('iblock');
$el = new CIBlockElement();
$fileName = 'dealers.csv';
$csvData = file_get_contents($fileName);
$lines = explode(PHP_EOL, $csvData);
$array = array();
print_pre(array_shift($lines));
foreach ($lines as $line) {
    $ar = str_getcsv($line, ';');
    $competence = explode('.', $ar[3]);
    array_walk($competence, function (&$item){
        $item = trim($item);
    });
    $site = explode(',', $ar[4]);
    array_walk($site, function (&$item){
        $item = trim($item);
    });
    $item = [
        'NAME' => $ar[2],
        'IBLOCK_ID' => 20,
        'PROPERTY_VALUES' => [
            'country' => $ar[0],
            'city' => $ar[1],
            'competence' => array_filter($competence),
            'site' => array_filter($site),
            'address' => $ar[5],
            'phone' => $ar[6],
            'coordinates' => $ar[7],
        ]
    ];

//    if(!$result = $el->Add($item)){
//        print_pre($ar, $el->LAST_ERROR);
//    }

    $array[] = $item;
}
print_pre($array);
?><?$APPLICATION->IncludeComponent(
	"bitrix:main.register",
	"",
	Array(
		"USER_PROPERTY_NAME" => ""
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>