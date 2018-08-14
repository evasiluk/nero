<?php
$arUrlRewrite=array (
  3 => 
  array (
    'CONDITION' => '#^/online/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  8 => 
  array (
    'CONDITION' => '#^/content/lines/auto-rollers/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/content/lines/auto-rollers/index.php',
    'SORT' => 100,
  ),
  5 => 
  array (
    'CONDITION' => '#^/bitrix/services/ymarket/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/bitrix/services/ymarket/index.php',
    'SORT' => 100,
  ),
  7 => 
  array (
    'CONDITION' => '#^/en/content/about/news/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/en/content/about/news/index.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^/content/about/news/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/content/about/news/index.php',
    'SORT' => 100,
  ),
  4 => 
  array (
    'CONDITION' => '#^/online/(/?)([^/]*)#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  2 => 
  array (
    'CONDITION' => '#^/stssync/calendar/#',
    'RULE' => '',
    'ID' => 'bitrix:stssync.server',
    'PATH' => '/bitrix/services/stssync/calendar/index.php',
    'SORT' => 100,
  ),
  0 => 
  array (
    'CONDITION' => '#^/content/news/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/content/news/index.php',
    'SORT' => 100,
  ),
    array(
        "CONDITION" => "#^/managers/dealer/(.*)/(.*)#",
        "RULE" => "uid=\$1",
        "ID" => "",
        "PATH" => "/managers/dealer/index.php",
    ),
);
