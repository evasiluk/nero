<?
//print_r($_GET);

$view = intval($_GET['view']);

if($arParams['filter_id'] == '') $arParams['filter_id'] = 1;
if($arParams['form_action'] == '') $arParams['form_action'] = '/catalog/tires/car/';
?>
<div class="filter" id="filter-battery-<?=$arParams['filter_id']?>">
	<!--<div class="count">Всего товаров: <b>4 600</b></div>-->
	<div class="title">Подбор товаров</div>
	<ul class="fTabs">
		<li class="ui-tabs-active"><a href="#filter-battery-1-1">По параметрам</a></li>
		<li><a href="#filter-battery-1-2">По марке авто</a></li>
	</ul>
	<div class="filterBlock" id="filter-battery-1-1">
		<form id="filter_form_battery1" action="<?=$arParams['form_action']?>" method="get">
			<input type="hidden" name="tab" value="1" />
			<input type="hidden" name="view" value="<?=$view?>" />
		<ul class="fParams">
			<li>
				<div class="label">Емкость:</div>
				<select name="capacity">
					<?=$arResult['CAPACITY']?>
				</select>
			</li>
			<!--<li>
				<div class="label">Полярность:</div>
				<select name="polarity">
					<?=$arResult['POLARITY']?>
				</select>
			</li>-->
			<!--<li>
				<div class="label">Ширина:</div>
				<select name="width">
					<?=$arResult['WIDTH']?>
				</select>
			</li>
			<li>
				<div class="label">Грубина:</div>
				<select name="depth">
					<?=$arResult['DEPTH']?>
				</select>
			</li>
			<li>
				<div class="label">Высота:</div>
				<select name="height">
					<?=$arResult['HEIGHT']?>
				</select>
			</li>
			<li>
				<div class="label">Пусковой ток (А):</div>
				<select name="tok">
					<?=$arResult['TOK']?>
				</select>
			</li>-->
			<!--<li>
				<div class="label">Тип клемм:</div>
				<select name="type_terminals">
					<?=$arResult['TYPE_TERMINALS']?>
				</select>
			</li>-->
			<li>
				<div class="label">Производитель:</div>
				<select name="manufacturer">
					<?=$arResult['MANUFACTURER']?>
				</select>
			</li>
		</ul>
		
		<?
		/* Дописал Игорь для включения/отключения ярлыков "Новинки", "Спецпредложения", "Сниженная цена" через инфоблок */
		$arSelect_i = Array("ID","ACTIVE"); // выборка нужных значений
		$arFilter_i = Array("IBLOCK_ID" => 29);
		$res_i = CIBlockElement::GetList(Array(), $arFilter_i, false, Array("nPageSize"=>50), $arSelect_i);
		$setting_i = Array();
		$count_i = 0;
		while($ob_i = $res_i->GetNextElement())
		{
			$arFields_i = $ob_i->GetFields();
			$setting_i[$count_i] = $arFields_i[ACTIVE];
			$count_i++;
		}
		/* Конец */
		
		// $setting_i[0] - "Новинки"
		// $setting_i[1] - "Спецпредложения"
		// $setting_i[2] - "Сниженная цена"
		?>
		
		<ul class="fParams2">
			<li<? if ($setting_i[0] == 'N') print ' style="display: none;"'; ?>><span class="fNovelty"><input type="checkbox" id="filter-param-1" name="novelty"<?=$arResult['novelty_checked']?>></span> <label for="filter-param-1">Новинки</label></li>
			<li<? if ($setting_i[1] == 'N') print ' style="display: none;"'; ?>><span class="fSpecial"><input type="checkbox" id="filter-param-2" name="special_offer"<?=$arResult['special_offer_checked']?>></span> <label for="filter-param-2">Спецпредложения</label></li>
			<li<? if ($setting_i[2] == 'N') print ' style="display: none;"'; ?>><span class="fDiscount"><input type="checkbox" id="filter-param-3" name="sale"<?=$arResult['sale_checked']?>></span> <label for="filter-param-3">Сниженная цена</label></li>
		</ul>
		<div style="height: 50px;"></div>
		<a href="javascript:void(0);" onClick="$(this).parent().reset_form();" class="resetBtn">Сбросить</a>
		<a href="javascript:void(0);" onClick="$('#filter_form_battery1').submit();" class="btn">Открыть</a>
		</form>
	</div>
	<div class="filterBlock ui-tabs-hide" id="filter-battery-1-2">
		<form id="filter_form_battery2" action="<?=$arParams['form_action']?>" method="get">
			<input type="hidden" class="chained_select_db_type" id="chained_select_db_type" value="battery" /> 
			<input type="hidden" name="tab" value="2" />
			<input type="hidden" name="prop_mark"         props_code="battery" in_order="yes" prop_name="mark" value="<?=$arResult['mark_filter_battery']['mark']?>" />
			<input type="hidden" name="prop_model"        props_code="battery" in_order="yes" prop_name="model" value="<?=$arResult['mark_filter_battery']['model']?>" />
			<input type="hidden" name="prop_modification" props_code="battery" in_order="yes" prop_name="modification" value="<?=$arResult['mark_filter_battery']['modification']?>" />
			<input type="hidden" name="prop_date_start"   prop="date_start"   subj="filter" props_code_add="battery" value="<?=$arResult['mark_filter_battery']['date_start']?>" />
			<input type="hidden" name="prop_date_end"     prop="date_end"     subj="filter" props_code_add="battery" value="<?=$arResult['mark_filter_battery']['date_end']?>" />
			<input type="hidden" name="prop_emkost_ot"    prop="emkost_ot"    subj="filter" props_code_add="battery" value="<?=$arResult['mark_filter_battery']['emkost_ot']?>" />
			<input type="hidden" name="prop_emkost_do"    prop="emkost_do"    subj="filter" props_code_add="battery" value="<?=$arResult['mark_filter_battery']['emkost_do']?>" />
			<input type="hidden" name="prop_tok_xol_prok" prop="tok_xol_prok" subj="filter" props_code_add="battery" value="<?=$arResult['mark_filter_battery']['tok_xol_prok']?>" />
			<input type="hidden" name="prop_diametr_klem" prop="diametr_klem" subj="filter" props_code_add="battery" value="<?=$arResult['mark_filter_battery']['diametr_klem']?>" />
			<input type="hidden" name="prop_polarnost"    prop="polarnost"    subj="filter" props_code_add="battery" value="<?=$arResult['mark_filter_battery']['polarnost']?>" />			
			<input type="hidden" name="view" value="<?=$view?>" />
		<ul class="fParams">
			<li>
				<div class="label">Марка:</div>
				<select name="mark" class="chained_select_db forward_select" order="1" pos="first" default="Любая" select_code="battery"> 
					<?=$arResult['mark']?>
				</select>						
			</li>
			<li>
				<div class="label"><span id="battery_loader_2" style="display:none"><img src="http://bagoria.by/bitrix/templates/bagoria/i/loader.gif"></span> Модель:</div>
				<select name="model" class="chained_select_db forward_select <? if($arResult['mark_filter_battery']['model'] == '') echo 'disabled';?>" order="2" pos="inside" default="Любая" select_code="battery" <? if($arResult['mark_filter_battery']['model'] == '') echo 'disabled="disabled"';?>>   
					<?=$arResult['model']?>
				</select>			
			</li>
			<li>
				<div class="label"><span id="battery_loader_3" style="display:none"><img src="http://bagoria.by/bitrix/templates/bagoria/i/loader.gif"></span> Модификация:</div>
				<select name="modification" class="chained_select_db forward_select <? if($arResult['mark_filter_battery']['model'] == '') echo 'disabled';?>" order="3" pos="last" act="get"  default="Любая" select_code="battery" battery="battery" <? if($arResult['mark_filter_battery']['model']  == '') echo 'disabled="disabled"';?>> 
					<?=$arResult['modification']?>
				</select>		
			</li>
		</ul>
		<a href="javascript:void(0);" onClick="$(this).parent().reset_form(); reset_chained_selects_db();" class="resetBtn">Сбросить</a>
		<a href="javascript:void(0);" onClick="$('#filter_form_battery2').submit();" type="battery" class="btn disabled">Открыть</a>
		</form>
	</div>
	<script>
		$(document).ready(function(){
			$('#filter-battery-<?=$arParams['filter_id']?>').tabs();
		})
	</script>
</div>
</form>
<div id="battery_hidden_params" style="display:none;"></div>
<script type="text/javascript">
$(function() {

    <?

    if($_GET['tab'] == 1) echo '$("#ui-id-1").trigger("click");';
    if($_GET['tab'] == 2) echo '$("#ui-id-2").trigger("click");';
    if($_GET['tab'] == 3) echo '$("#ui-id-3").trigger("click");';
    if($_GET['tab'] == 4) echo '$("#ui-id-4").trigger("click");';

    ?>

});
</script>