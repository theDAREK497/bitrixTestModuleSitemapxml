<?
$arModuleCfg = [
	'MODULE_ID' => mb_strtolower('is_pro.sitemap_xml'),

	/* Настройки модуля */
	'options_list' => [

		/* Пример настройки с выбором (select) */

		'MODULE_MODE' => [ 					/* Имя настройки */
			'type' => 'select', 			/* Тип поля настройки */
			'values' => [					/* Значения настройки */
				'off',
				'test',
				'on'
			],
			'default' => 'off'				/* Значение по умолчанию */
		],

		'AGENT_TIME' => [
			'type' => 'text',
			'default' => '86400'
		],

		'DIRECTORY' => [
			'type' => 'text',
			'default' => ''
		],
	]
];