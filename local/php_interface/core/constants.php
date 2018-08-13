<?php
define('DEFAULT_TEMPLATE_PATH', '/local/templates/.default');
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
define('DEFAULT_ASSETS_PATH', DEFAULT_TEMPLATE_PATH . '/assets');
define('DEFAULT_IMG_PATH', DEFAULT_ASSETS_PATH . '/images');
define('DEFAULT_CSS_PATH', DEFAULT_ASSETS_PATH . '/css');
define('DEFAULT_JS_PATH', DEFAULT_ASSETS_PATH . '/js');

define('BY_HOST', 'nero.test.astronim.com');
define('MSK_HOST', 'nero-msk.test.astronim.com');
define('SPB_HOST', 'nero-spb.test.astronim.com');
define('UA_HOST', 'nero-ua.test.astronim.com');
define('EN_HOST', 'nero-en.test.astronim.com');
define('CURRENT_USER_HOST', $_SERVER["HTTP_HOST"]);


define('GRECAPTCHA_PUBLIC', '6Lc081QUAAAAALVCChx-q1rrrPN1L9b1b1xyzthl');
define('GRECAPTCHA_PRIVATE', '6Lc081QUAAAAAEzayyO29Uaqzp7jQY2eI1pcrBN_');