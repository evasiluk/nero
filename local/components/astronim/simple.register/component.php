<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $USER;
if($USER->IsAuthorized()) {
    $arResult["USER_REGISTERED"] = true;
}

$arResult["PRIVATE_KEY"] = GRECAPTCHA_PRIVATE;
$arResult["PUBLIC_KEY"] = GRECAPTCHA_PUBLIC;

$arResult["ERRORS"] = [];


if (isset($_POST['g-recaptcha-response'])){
    $url_to_google_api = "https://www.google.com/recaptcha/api/siteverify";
    $secret_key = GRECAPTCHA_PRIVATE;
    $query = $url_to_google_api . '?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response'] . '&remoteip=' . $_SERVER['REMOTE_ADDR'];
    $data = json_decode(file_get_contents($query));
    if ($data->success) {
        $email = $_POST["email"];

        if ($ar = CUser::GetList($by = "timestamp_x", $order = "desc", ['EMAIL' => $email])->GetNext()) {
            $arResult["ERRORS"][] = "Данный Email уже занят :(";
        } else {

            $user = new CUser;

            $arFields = array(
                'NAME'             => $_POST["name"],
                'EMAIL'            => $_POST["email"],
                'LOGIN'            => $_POST["email"], // минимум 3 символа
                'ACTIVE'           => 'Y',
                'PASSWORD'         => $_POST["password"], // минимум 6 символов
                'CONFIRM_PASSWORD' => $_POST["password_confirm"],
                'GROUP_ID'         => array(26),
                'PERSONAL_PHONE'   => $_POST["phone"],
                "PERSONAL_COUNTRY" => $_POST["country"],
                "UF_NERO_SITE"     => CURRENT_USER_HOST
            );

            if($ID = $user->Add($arFields)) {
                global $USER;
                $USER->Authorize($ID);
            }
        }
    } else {
        $arResult["ERRORS"][] = 'Подтвердите, что Вы не робот.';
    }
}

$this->IncludeComponentTemplate();
?>

