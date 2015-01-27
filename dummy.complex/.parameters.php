<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

$arComponentParameters = array(
	'PARAMETERS' => array(
		'SEF_MODE' => Array(
			'default' => array(
				'NAME' => 'Страница списка',
				'DEFAULT' => '',
				'VARIABLES' => array(),
			),
			'section' => array(
				'NAME' => 'Страница раздела',
				'DEFAULT' => '#SECTION_ID#/',
				'VARIABLES' => array('SECTION_ID'),
			),
			'detail' => array(
				'NAME' => 'Детальная страница',
				'DEFAULT' => '#SECTION_ID#/#ELEMENT_ID#/',
				'VARIABLES' => array('SECTION_ID', 'ELEMENT_ID'),
			),
		),
	),
);
?>