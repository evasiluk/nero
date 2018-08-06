<?
//print_r($_GET);

$view = intval($_GET['view']);

if($arParams['filter_id'] == '') $arParams['filter_id'] = 1;
if($arParams['form_action'] == '') $arParams['form_action'] = '/catalog/tires/car/';

?>
<div class="filter" id="filter-wheels-<?=$arParams['filter_id']?>">
	<!--<div class="count">Всего товаров: <b>4 600</b></div>-->
	<div class="title">Подбор товаров</div>
	<ul class="fTabs">
		<li <?if($_REQUEST['tab']==1 or !isset($_REQUEST['tab'])) echo 'class="ui-tabs-active"';?>><a href="#filter-wheels-1-1">По параметрам</a></li>
		<li <?if($_REQUEST['tab']==2) echo 'class="ui-tabs-active"';?>><a href="#filter-wheels-1-2">По марке авто</a></li>
		<li <?if($_REQUEST['tab']==3) echo 'class="ui-tabs-active"';?>><a href="#filter-wheels-1-3">Мультипаки и аксессуары</a></li> 
	</ul>
	<div class="filterBlock" id="filter-wheels-1-1">
		<form id="filter_form_wheels1" action="<?=$arParams['form_action']?>" method="get">
			<input type="hidden" id="chained_select_type" value="diski" />
			<input type="hidden" name="tab" value="1" />
			<input type="hidden" name="view" value="<?=$view?>" />
		<ul class="fParams">
			<li>
				<div class="label">Диаметр:</div>
				<select name="diametr">
					<?=$arResult['DIAMETR']?>
				</select>
			</li>
			<li>
				<div class="label">PCD:</div>
				<select name="pcd1" class="chained_select" select_code="diski">
					<?=$arResult['PCD1']?>
				</select>
				/
				<select name="pcd2" class="chained_select" select_code="diski">
					<?=$arResult['PCD2']?>
				</select>
			</li>
			<li>
				<div class="label">Ширина:</div>
				от <select name="width_from">
					<?=$arResult['WIDTH_FROM']?>
				</select>
				до <select name="width_to">
					<?=$arResult['WIDTH_TO']?>
				</select>
			</li>
			<li>
				<div class="label">Вылет (ET):</div>
				от <select name="sortie_from">
					<?=$arResult['SORTIE_FROM']?>
				</select>
				до <select name="sortie_to">
					<?=$arResult['SORTIE_TO']?>
				</select>
			</li>
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
			<li<? if ($setting_i[0] == 'N') print ' style="display: none;"'; ?>><span class="fNovelty"><input type="checkbox" id="filter-param-6" name="novelty"<?=$arResult['novelty_checked']?>></span> <label for="filter-param-6">Новинки</label></li>
			<li<? if ($setting_i[1] == 'N') print ' style="display: none;"'; ?>><span class="fSpecial"><input type="checkbox" id="filter-param-7" name="special_offer"<?=$arResult['special_offer_checked']?>></span> <label for="filter-param-7">Спецпредложения</label></li>
			<li<? if ($setting_i[2] == 'N') print ' style="display: none;"'; ?>><span class="fDiscount"><input type="checkbox" id="filter-param-8" name="sale"<?=$arResult['sale_checked']?>></span> <label for="filter-param-8">Сниженная цена</label></li>		
			<li><span><input type="checkbox" id="filter-wheels-param-3" onClick="$('input[name=stamped]').removeAttr('checked');" name="molten"<?=$arResult['molten_checked']?>></span> <label for="filter-wheels-param-3">Литой</label></li>
			<li><span><input type="checkbox" id="filter-wheels-param-4" onClick="$('input[name=molten]').removeAttr('checked');" name="stamped"<?=$arResult['stamped_checked']?>></span> <label for="filter-wheels-param-4">Штампованный</label></li>			
		</ul>
		<div style="height: 50px;"></div>
		<a href="javascript:void(0);" onClick="$(this).parent().reset_form(); reset_chained_selects('diski');" class="resetBtn">Сбросить</a>
		<a href="javascript:void(0);" onClick="$('#filter_form_wheels1').submit();" class="btn">Открыть</a>
		</form>
	</div>
	<div class="filterBlock ui-tabs-hide" id="filter-wheels-1-2">
		<form id="filter_form_wheels2" action="<?=$arParams['form_action']?>" method="get">
			<input type="hidden" class="chained_select_db_type" id="chained_select_db_type" value="wheels_car" />
			<input type="hidden" name="tab" value="2" />
			<input type="hidden" name="prop_mark"  props_code="wheels_car" in_order="yes" value="<?=$arResult['mark_filter']['mark']?>" />
			<input type="hidden" name="prop_model" props_code="wheels_car" in_order="yes" value="<?=$arResult['mark_filter']['model']?>" />
			<input type="hidden" name="prop_year"  props_code="wheels_car" in_order="yes" value="<?=$arResult['mark_filter']['year']?>" />
			<input type="hidden" name="prop_modification" props_code="wheels_car" in_order="yes" value="<?=$arResult['mark_filter']['modification']?>" />
			<input type="hidden" name="prop_params"  props_code="wheels_car" in_order="no" value="<?=$arResult['mark_filter']['params']?>" /> 
			<input type="hidden" name="prop_pcd" prop="pcd" subj="filter" props_code_add="wheels_car" value="<?=$arResult['mark_filter']['PCD']?>" />
			<input type="hidden" name="prop_diametr" prop="diametr" subj="filter" props_code_add="wheels_car" value="<?=$arResult['mark_filter']['DIA']?>" />
			<input type="hidden" name="prop_ET" prop="ET" subj="pattern" props_code_add="wheels_car" value="<?=$arResult['mark_filter']['ET']?>" />
			<input type="hidden" name="prop_pos_diametr" prop="pos_diametr" subj="pattern" props_code_add="wheels_car" value="<?=$arResult['mark_filter']['POS_DIAMETR']?>" />
			<input type="hidden" name="view" value="<?=$view?>" />
			<ul class="fParams">
				<li>
					<div class="label">Марка:</div>
					<select name="mark" class="chained_select_db forward_select" order="1" pos="first" default="Любая" select_code="wheels_car"> 
						<?=$arResult['mark']?>
					</select>				
				</li>
				<li>
					<div class="label"><span id="wheels_car_loader_2" style="display:none"><img src="http://bagoria.by/bitrix/templates/bagoria/i/loader.gif"></span> Модель:</div>
					<select name="model" class="chained_select_db forward_select <? if($arResult['mark_filter']['model'] == '') echo 'disabled';?>" order="2" pos="inside" default="Любая" select_code="wheels_car" <? if($arResult['mark_filter']['model'] == '') echo 'disabled="disabled"';?>>   
						<?=$arResult['model']?>
					</select>				
				</li>			
				<li>
					<div class="label"><span id="wheels_car_loader_3" style="display:none"><img src="http://bagoria.by/bitrix/templates/bagoria/i/loader.gif"></span> Год выпуска:</div>
					<select name="year" class="chained_select_db forward_select <? if($arResult['mark_filter']['model'] == '') echo 'disabled';?>" order="3" pos="inside" default="Любой" select_code="wheels_car" <? if($arResult['mark_filter']['model'] == '') echo 'disabled="disabled"';?>> 
						<?=$arResult['year']?>
					</select>				
				</li>
				<li> 
					<div class="label"><span id="wheels_car_loader_4" style="display:none"><img src="http://bagoria.by/bitrix/templates/bagoria/i/loader.gif"></span> Модификация:</div>
					<select name="modification" class="chained_select_db forward_select <? if($arResult['mark_filter']['model'] == '') echo 'disabled';?>" order="4" pos="inside" default="Любая" select_code="wheels_car" <? if($arResult['mark_filter']['model']  == '') echo 'disabled="disabled"';?>> 
						<?=$arResult['modification']?>
					</select>				
				</li>					
				<li> 
					<div class="label"><span id="wheels_car_loader_5" style="display:none"><img src="http://bagoria.by/bitrix/templates/bagoria/i/loader.gif"></span> Параметры диска:</div>
					<select name="params" class="chained_select_db forward_select groups <? if($arResult['mark_filter']['model'] == '') echo 'disabled';?>" order="5" pos="last" act="get" default="Любые" select_code="wheels_car" add_params="pcd" wheels_car="wheels_car" group_name_1="Заводские" group_name_2="Замена" group_name_3="Тюнинг" <? if($arResult['mark_filter']['model'] == '') echo 'disabled="disabled"';?>>
						<?=$arResult['params']?>			
					</select>				
				</li>		
			</ul>
			<a href="javascript:void(0);" onClick="$(this).parent().reset_form(); reset_chained_selects_db();" class="resetBtn">Сбросить</a>
			<a href="javascript:void(0);" onClick="check_chained_select('filter_form_wheels2')" type="wheels_car" class="btn disabled">Открыть</a>
			<!-- $('#filter_form_wheels2').submit(); -->			
		</form>  
	</div>
	<div class="filterBlock ui-tabs-hide" id="filter-wheels-1-3">
		<form id="filter_form_wheels3" action="<?=$arParams['form_action']?>" method="get">
			<input type="hidden" name="tab" value="3" />
			<input type="hidden" name="view" value="<?=$view?>" />
		<ul class="fParams">
			<li>
				<div class="label">Категория:</div>
				<select name="category">
					<?=$arResult['CATEGORY']?>
				</select>
			</li>
			<li>
				<div class="label">Поиск по наименованию:</div>
				<div class="fastSearch">
					<input type="text" id="name_search" name="name_search" value="<?=$_REQUEST['name_search']?>">
				</div>
			</li>
		</ul>
		<a href="javascript:void(0);" onClick="$(this).parent().reset_form();" class="resetBtn">Сбросить</a>
		<a href="javascript:void(0);" onClick="$('#filter_form_wheels3').submit();" class="btn">Открыть</a>
		</form>
	</div>	
	<script>
		$(document).ready(function(){
			$('#filter-wheels-<?=$arParams['filter_id']?>').tabs();
		})
	</script>
</div>
</form>
<div id="wheels_car_hidden_params" style="display:none;"></div>
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