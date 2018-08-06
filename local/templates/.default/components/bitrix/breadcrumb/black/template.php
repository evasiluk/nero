<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$curPage = $GLOBALS['APPLICATION']->GetCurPage($get_index_page=false);

if ($curPage != SITE_DIR)
{
	if (empty($arResult) || (!empty($arResult[count($arResult)-1]['LINK']) && $curPage != urldecode($arResult[count($arResult)-1]['LINK'])))
		$arResult[] = array('TITLE' =>  htmlspecialcharsback($GLOBALS['APPLICATION']->GetTitle(false, true)), 'LINK' => $curPage);
}

if(empty($arResult))
	return "";

$strReturn = '<div class="backnav">
<div class="gocat">
				<a href="/content/lines/auto-rollers/">
					<svg class="ico-basket" viewBox="0 0 16 16"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#ico-catalog"></use></svg>
					<span>В каталог</span>
				</a>
			</div>
<ul>';

$num_items = count($arResult);
for($index = 0, $itemSize = $num_items; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	
	if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
		$strReturn .= "<li><a href='{$arResult[$index]["LINK"]}'>{$title}</a></li>\n";
	else
		$strReturn1 .= '<li><span>'.$title.'</span></li>';
}

$strReturn .= '</ul></div>';

return $strReturn;