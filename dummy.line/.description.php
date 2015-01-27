<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	'NAME' => 'Компонент-пустышка для списков',
	'DESCRIPTION' => 'Компонент-пустышка для списков. Используется для создания компонентов-списков.',
	'ICON' => '/images/dummy_logo.gif',
	'SORT' => 10,
	'CACHE_PATH' => 'Y',
	'PATH' => array(
		'ID' => 'Nikita',
		'CHILD' => array(
			'ID' => 'dummy',
			'NAME' => 'Компонент-пустышка',
			'SORT' => 10,
		)
	),
);

?>