<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

/**
 * Компонент-пустышка.
 * Используется как основа для создания своих компонентов.
 * 
 * @author nikita@kodix.ru
 * @copyright Kodix 2014
 * */

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

// <-- закончили обрабатывать параметры

// параметры постранички
$ar_nav_params = array(
	'nPageSize' => $arParams['PAGE_SIZE'],
	'bShowAll' => $arParams['SHOW_ALL'],
);

// кэшируем
if($this->StartResultCache()) {
	
	// совсем необязательно, что тут будет iblock или только iblock
	if(!CModule::IncludeModule('iblock')) {
		$this->AbortResultCache();
		ShowError(GetMessage('IBLOCK_MODULE_NOT_INSTALLED'));
		return;
	}
	
	$this->IncludeComponentTemplate(); // кэгируем вместе с швблоном, если без шаблона, то надо вынести за скобки	
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