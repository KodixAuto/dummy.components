<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

/**
 * Компонент-пустышка для списков.
 * Используется как основа для создания своих компонентов-списков.
 * 
 * @author nikita@kodix.ru
 * @copyright Kodix 2014
 * */

CPageOption::SetOptionString('main', 'nav_page_in_session', 'Y'); // сохраняем постранчику в сессии

// часто используемые глобальные переменные
global $APPLICATION, $USER, $DB;

// обработка параметров --->
// лишние пробелы и символы
$arParams = array_map(function($item) {
	return trim(htmlspecialchars($item));
}, $arParams);

// время кэширования
if(!isset($arParams['CACHE_TIME']))
	$arParams['CACHE_TIME'] = 300;
else
	$arParams['CACHE_TIME'] = intval($arParams['CACHE_TIME']);

/* --> тут свои параметры <-- */

// источники данных -->
$arParams['IBLOCK_ID'] = intval($arParams['IBLOCK_ID']);
$arParams['SORT_ORDER'] = in_array($arParams['SORT_ORDER'], array('ASC', 'DESC')) ?: 'DESC'; // по уменьшению по умолчанию

if(!isset($arParams['FILTER']))
	$arParams['FILTER'] = array();

if(!isset($arParams['SELECT']))
	$arParams['SELECT'] = array();

// постраничка -->
$arParams['SHOW_ALL'] = $arParams['SHOW_ALL'] == 'Y' ?: 'N'; // показывать все элементы сразу

if(isset($arParams['TOP_COUNT'])) // ограничение выборки сверху
	$arParams['TOP_COUNT'] = intval($arParams['TOP_COUNT']);

$arParams['NUM_PAGE'] = intval($arParams['NUM_PAGE']);
// если страница не задана, то будет первая
$arParams['NUM_PAGE'] = $arParams['NUM_PAGE'] > 0 ? $arParams['NUM_PAGE'] : 1;

$arParams['PAGE_SIZE'] = intval($arParams['PAGE_SIZE']);
// если размер страницы не задан, то будет по 10 эл-в
$arParams['PAGE_SIZE'] = $arParams['PAGE_SIZE'] > 0 ? $arParams['PAGE_SIZE'] : 10;

// прочие настройки -->
$arParams['SET_TITLE'] = $arParams['SET_TITLE'] == 'Y' ?: 'N';
$arParams['ADD_TO_CHAIN'] = $arParams['ADD_TO_CHAIN'] == 'Y' ?: 'N';

// <-- закончили обрабатывать параметры

// параметры постранички
$ar_nav_params = array(
	'nPageSize' => $arParams['PAGE_SIZE'],
	'bShowAll' => $arParams['SHOW_ALL'],
);

$ar_navigation = CDBResult::GetNavParams($ar_nav_params);

// кэшируем
if($this->StartResultCache(false, array($ar_navigation))) {
	// $ar_navigation используется в кэше для сохранения постранчики
	
	// совсем необязательно, что тут будет iblock или только iblock
	if(!CModule::IncludeModule('iblock')) {
		$this->AbortResultCache();
		ShowError('Отсутствует модуль инфоблоков');
		return;
	}
	
	// результирующий массив
	$arResult = array(
		'ELEMENTS' => array(),
		'NAV' => ''
	);
	
	// параметры выборки
	
	// сортировка
	$ar_order = array(
		$arParams['SORT_BY'] => $arParams['SORT_ORDER']
	);
	
	// фильтр
	$ar_filter = array(
		'IBLOCK_ID' => $arParams['IBLOCK_ID']
	);
	
	$ar_filter = array_merge($ar_filter, $arParams['FILTER']); // объединяем с пользовательским фильтром
	
	// выбираемы поля
	$ar_select = array(
		'ID', 'NAME', 'PREVIEW_TEXT', 'PREVIEW_PICTURE', 'CODE', 'XML_ID'
	);
	
	$ar_select = array_merge($ar_select, $arParams['SELCT']); // объединяем с пользовательским массивом полей
	
	// выборка
	$Elements = CIBlockElement::GetList($ar_order, $ar_filter, false, $ar_nav_params, $ar_select);
	
	// постранчика
	$Elements->NavStart($arParams['PAGE_SIZE']);
	
	while($ar_element = $Elements->GetNext()) {
		$arResult['ELEMENTS'][] = $ar_element;
		// --> тут самое место для доп. обработки (получение доп. параметров, массивов изображений и т.п.)
	}
	
	// получаем вывод постранички
	if ($ar_navigation) 
		$arResult['NAV'] = $Elements->GetPageNavStringEx($navComponentObject, '', $arParams['NAV_TEMPLATE'], false);
	
	$this->IncludeComponentTemplate(); // кэшируем вместе с шаблоном, если без шаблона, то надо вынести за скобки
}	

// если мы работаем с инфоблоками и эрмитажем, то так мы можем вывести кнопки
if(
	$arParams['IBLOCK_ID'] > 0 // если мы работаем с инфоблоками
	&& $USER->IsAuthorized()
	&& $APPLICATION->GetShowIncludeAreas()
	&& CModule::IncludeModule('iblock')
) {
	$arButtons = CIBlock::GetPanelButtons($arParams['IBLOCK_ID'], 0, 0, array('SECTION_BUTTONS' => false));
	$this->AddIncludeAreaIcons(CIBlock::GetComponentMenu($APPLICATION->GetPublicShowMode(), $arButtons));
}

// выставляем заголовок страницы (если это необходимо)
if($arParams['SET_TITLE'] == 'Y' && $title) {
	$APPLICATION->SetPageProperty('title', $title);
}

// добавляем ссылку на элемент в  брэдкрамбс
if($arParams['ADD_TO_CHAIN'] == 'Y' && $title && $path) {
	$APPLICATION->AddChainItem($title, $path);
}
?>