<?php
/*======================================================================*\
|| #################################################################### ||
|| # Package - Joomla Template based on YJSimpleGrid Framework          ||
|| # Copyright (C) 2010  Youjoomla.com. All Rights Reserved.            ||
|| # license - PHP files are licensed under  GNU/GPL V2                 ||
|| # license - CSS  - JS - IMAGE files  are Copyrighted material        ||
|| # bound by Proprietary License of Youjoomla.com                      ||
|| # for more information visit http://www.youjoomla.com/license.html   ||
|| # Redistribution and  modification of this software                  ||
|| # is bounded by its licenses                                         ||
|| # websites - http://www.youjoomla.com | http://www.yjsimplegrid.com  ||
|| #################################################################### ||
\*======================================================================*/
defined( '_JEXEC' ) or die( 'Restricted index access' );
//
$navigation 	= $document->params->get('slider_navigation_'.$mod_name.$clonedPageId.'');
$tabstype 		= $document->params->get('tabs_type_'.$mod_name.$clonedPageId.'');
$tabsClass		= '';
if(!$navigation){
	$navigation 	= $document->params->get('slider_navigation_'.$mod_name.'');
}
if(!$tabstype){
	$tabstype 	= $document->params->get('tabs_type_'.$mod_name.'');
}
if($tabstype == 'tabpills'){
	$tabsClass = ' tabpills';
}

$html .='<div class="yjsgModsChrome yjsgtabs'.$tabsClass.'">';
$html .='<div id="yjsgsliderHolder'.$mod_name.'" class="yjsgsliderHolder">';
// controls
$html .='<div class="yjsgsliderControlsTabs">';
if($navigation == 1){
	$html .='<a class="yjsgsliderNav getslide prev" href="#" data-getslide="prev">';
	$html .='<i></i>';
	$html .='</a>';
	$html .='<a class="yjsgsliderNav getslide next" href="#" data-getslide="next">';
	$html .='<i></i>';
	$html .='</a>';
}
$html .='<ul class="yjsgsliderPaginationTabs">';
$html .= implode($buildMenu);
$html .='</ul>';
$html .='</div>';
// end controls
$html .='<div id="yjsgsliderChrome_'.$mod_name.'" class="yjsgsliderChrome yjsgChromes">';
$html .=implode($buildTabs);
$html .='</div>';
$html .='<div class="yjsgsliderLoader"></div>';
$html .='</div>';
$html .='</div>';
