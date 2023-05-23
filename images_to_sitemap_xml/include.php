<?php
if (file_exists(__DIR__ . "/install/module.cfg.php")) {
	include(__DIR__ . "/install/module.cfg.php");
};

use Bitrix\Main\Loader;
Loader::includeModule($arModuleCfg['MODULE_ID']);

$arClasses=array(
	/* Библиотеки и классы для авто загрузки */
	/*
	'module_name\lib'=>'lib/lib.php',
    'module_name\cMain_module_name'=>'classes/general/cMain_module_name.php'
	*/
);

Loader::registerAutoLoadClasses($arModuleCfg['MODULE_ID'], $arClasses);
