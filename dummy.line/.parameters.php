<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule('iblock'))
	return;

$ar_iblocks = array();

$IBlocks = CIBlock::GetList(
	array('SORT' => 'ASC'),
	array('ACTIVE' => 'Y')
);

while($ar_iblock = $IBlocks->Fetch())
{
	$ar_iblocks[$ar_iblock['ID']] = $ar_iblock['NAME'];
}

$ar_sort_fields = Array(
		'ID' => 'ID элемента',
		'NAME' => 'Имя элемента',
		'ACTIVE_FROM' => 'Дата начала активности',
		'SORT' => 'Сортировка',
);

$ar_sorts = Array(
	'ASC' => 'По возрвстанию',
	'DESC' => 'По убыванию',
);

$arComponentParameters = array(
	'GROUPS' => array(
		'NAV' => array(
			'NAME' => 'Параметры постраничной навигации',
		),
	),
	'PARAMETERS'  =>  array(
		'IBLOCK_ID'  =>  array(
			'PARENT' => 'DATA_SOURCE',
			'NAME' => 'ID инфоблока',
			'TYPE' => 'LIST',
			'DEFAULT' => '',
			'VALUES' => $ar_iblocks,
			'ADDITIONAL_VALUES' => 'N',
		),
		'SORT_BY'  =>  Array(
			'PARENT' => 'DATA_SOURCE',
			'NAME' => 'Сортировка',
			'TYPE' => 'LIST',
			'DEFAULT' => 'SORT',
			'VALUES' => $ar_sort_fields,
			'ADDITIONAL_VALUES' => 'Y',
		),
		'SORT_ORDER'  =>  array(
			'PARENT' => 'DATA_SOURCE',
			'NAME' => 'Направление сортировки',
			'TYPE' => 'LIST',
			'DEFAULT' => 'DESC',
			'VALUES' => $ar_sorts,
			'ADDITIONAL_VALUES' => 'N',
		),
		
		'SHOW_ALL'  =>  array(
			'PARENT' => 'NAV',
			'NAME' => 'Показывать все элементы сразу',
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'N',
			'VALUE' => 'Y',
			'ADDITIONAL_VALUES' => 'Y',
		),
		'TOP_COUNT'  =>  array(
			'PARENT' => 'NAV',
			'NAME' => 'Всего элементов',
			'TYPE' => 'STRING',
			'DEFAULT' => '100',
		),
		'NUM_PAGE'  =>  array(
			'PARENT' => 'NAV',
			'NAME' => 'Номер страницы',
			'TYPE' => 'STRING',
			'DEFAULT' => '1',
		),
		'PAGE_SIZE'  =>  array(
			'PARENT' => 'NAV',
			'NAME' => 'Элементов на страницу',
			'TYPE' => 'LIST',
			'VALUES' => array(10, 20, 50, 100),
			'DEFAULT' => '10',
			'ADDITIONAL_VALUES' => 'Y',
		),
		'NAV_TEMPLATE'  =>  array(
			'PARENT' => 'NAV',
			'NAME' => 'Шаблон постраничной навигации',
			'TYPE' => 'STRING',
			'DEFAULT' => '',
			'ADDITIONAL_VALUES' => 'N',
		),
		
		/*
		'SET_TITLE' => array(),
		'ADD_TO_CHAIN' => array(
			'PARENT' => '',
			'NAME' => 'Добавить в цепочку навигации',
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'N',
			'VALUE' => 'Y',
			'ADDITIONAL_VALUES' => 'N',
		),
		*/
		'CACHE_TIME'  =>  array('DEFAULT' => 300)
	)
);
?>