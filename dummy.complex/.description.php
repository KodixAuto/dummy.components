<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

$arComponentDescription = array(
	'NAME' => 'Компонент-пустышка для комплексных',
	'DESCRIPTION' => 'Компонент-пустышка для создания комплексных компонентов',
	'ICON' => '/images/dummy_logo.gif',
	'SORT' => 10,
	'COMPLEX' => 'Y',
	'PATH' => array(
		'ID' => 'Nikita',
		'CHILD' => array(
			'ID' => 'dummy',
			'NAME' => 'Компонент-пустышка',
			'SORT' => 10,
		),
	),
);
?>