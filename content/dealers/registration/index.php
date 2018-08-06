<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Стать дилером");
?><?$APPLICATION->IncludeComponent(
	"bitrix:main.register",
	"",
	Array(
		"AUTH" => "Y",
		"REQUIRED_FIELDS" => array("NAME"),
		"SET_TITLE" => "N",
		"SHOW_FIELDS" => array(),
		"SUCCESS_PAGE" => "?registered",
		"USER_PROPERTY" => array("UF_SERVICES_ADDITION","UF_SERVICES_WHERE","UF_SERVICES"),
		"USER_PROPERTY_NAME" => "",
		"USE_BACKURL" => "Y"
	)
);?><br><br><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>