<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

if($arParams['SEF_URL_TEMPLATES']['list']=='') 
	$arParams['SEF_URL_TEMPLATES']['list'] = 'index.php';

$ar_default_url_templates_404 = array(
	'list' => '',
	'section' => '#SECTION_ID#/',
	'detail' => '#SECTION_ID#/#ELEMENT_ID#/'
);

if($arParams['SEF_MODE'] == 'Y') {
	
	$ar_variables = array();
	// парсим
	$ar_url_templates = CComponentEngine::MakeComponentUrlTemplates($ar_default_url_templates_404, $arParams['SEF_URL_TEMPLATES']);
	// получаем страницу
	$component_page = CComponentEngine::ParseComponentPath($arParams['SEF_FOLDER'], $ar_url_templates, $ar_variables);
	
}
else {
	ShowError('Не включен режим ЧПУ');
	return;
}

$this->IncludeComponentTemplate($component_page);
?>