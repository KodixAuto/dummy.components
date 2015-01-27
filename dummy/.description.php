<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	'NAME' => 'Компонент-пустышка',
	'DESCRIPTION' => 'Компонент-пустышка. Используется как база для создания новых компонентов',
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