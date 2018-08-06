<?php
defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();

\Bitrix\Main\Loader::registerAutoLoadClasses('astronim.voip', [
    'Astronim\Base' => 'classes/Base.php'
]);