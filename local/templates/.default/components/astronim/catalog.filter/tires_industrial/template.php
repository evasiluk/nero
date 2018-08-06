<?
//print_r($_GET);
 
$view = intval($_GET['view']);

if($arParams['filter_id'] == '') $arParams['filter_id'] = 1;
if($arParams['form_action'] == '') $arParams['form_action'] = '/catalog/tires/industrial/';

?>
<div class="filter" id="filter-industrial-<?=$arParams['filter_id']?>">
	<!--<div class="count">Всего товаров: <b>4 600</b></div>-->
	<div class="title">Подбор товаров</div>
	<ul class="fTabs">
		<li class="ui-tabs-active"><a href="#filter-industrial-1-1">По параметрам</a></li>
		<li><a href="#filter-industrial-1-2">По типу техники</a></li>
		<li><a href="#filter-industrial-1-3">Камеры и о/л для спецтехники</a></li>
	</ul>
	<div class="filterBlock" id="filter-industrial-1-1">
		<form id="filter_form_industrial1" action="<?=$arParams['form_action']?>" method="get">
			<input type="hidden" id="chained_select_type" value="industrial_params" />
			<input type="hidden" name="tab" value="1" />
			<input type="hidden" name="view" value="<?=$view?>" />
		<ul class="fParams">
			<li>
				<div class="label">Типоразмер:</div>
				<select name="size" class="chained_select" select_code="industrial_params"> 
					<?=$arResult['SIZES']?> 
				</select>
			</li>
			<li>
				<div class="label">Норма слойности:</div>
				<select name="ply_rating" class="chained_select" select_code="industrial_params">
					<?=$arResult['PLY_RATING']?>
				</select>
			</li>
			<li>
				<div class="label">Индекс нагрузки:</div>
				<select name="index" class="chained_select" select_code="industrial_params">
					<?=$arResult['INDEX']?>
				</select>
			</li>
		</ul>
		<a href="javascript:void(0);" onClick="$(this).parent().reset_form(); reset_chained_selects('industrial_params');" class="resetBtn">Сбросить</a>
		<a href="javascript:void(0);" onClick="$('#filter_form_industrial1').submit();" class="btn">Открыть</a>
		</form>
	</div>
	<div class="filterBlock ui-tabs-hide" id="filter-industrial-1-2">
		<form id="filter_form_industrial2" action="<?=$arParams['form_action']?>" method="get">
			<input type="hidden" class="chained_select_type" id="chained_select_type" value="industrial_type" />
			<!-- <input type="hidden" class="chained_select_db_type" id="chained_select_db_type" value="industrial_type" /> -->
			<input type="hidden" name="prop_manufacturer"  props_code="tires_car" in_order="yes" value="<?=$arResult['industrial_filter']['manufacturer']?>" />
			<input type="hidden" name="prop_models" props_code="tires_car" in_order="yes" value="<?=$arResult['industrial_filter']['models']?>" />
			<input type="hidden" name="prop_tiporazmer"  props_code="tires_car" in_order="no"  value="<?=$arResult['industrial_filter']['tiporazmer']?>" /> 			
			<input type="hidden" name="tab" value="2" />
			<input type="hidden" name="view" value="<?=$view?>" />
		<ul class="fParams">
			<li>
				<div class="label">Марка:</div>
				<select name="manufacturer" class="chained_select forward_select" order="1" pos="first" default="Любая" select_code="industrial_type">
					<?=$arResult['manufacturer']?>
				</select>
			</li>  
			<li>
				<div class="label"><span id="industrial_type_loader_2" style="display:none"><img src="http://bagoria.by/bitrix/templates/bagoria/i/loader.gif"></span> Модель:</div>
				<select name="models" class="chained_select forward_select <? if($arResult['industrial_type']['models'] == '') echo 'disabled';?>" order="2" pos="inside" default="Любая" select_code="industrial_type" <? if($arResult['industrial_type']['models'] == '') echo 'disabled="disabled"';?>>   
					<?=$arResult['models']?>
				</select>		
			</li>	
			<li>
				<div class="label"><span id="industrial_type_loader_3" style="display:none"><img src="http://bagoria.by/bitrix/templates/bagoria/i/loader.gif"></span> Типоразмер:</div>
				<select name="tiporazmer" class="chained_select forward_select groups <? if($arResult['mark_filter']['models'] == '') echo 'disabled';?>" order="3" pos="last" default="Любой" select_code="industrial_type" industrial_type="industrial_type" group_name_1="Заводские" group_name_2="Замена" <? if($arResult['mark_filter']['models'] == '') echo 'disabled="disabled"';?>>
					<?=$arResult['tiporazmer']?>			
				</select>		
			</li>
		</ul>
		<a href="javascript:void(0);" onClick="$(this).parent().reset_form(); reset_chained_selects('industrial_type');" class="resetBtn">Сбросить</a>
		<a href="javascript:void(0);" onClick="$('#filter_form_industrial2').submit();"  type="industrial_type" class="btn disabled">Открыть</a>
		</form>
	</div>
	<div class="filterBlock ui-tabs-hide" id="filter-industrial-1-3">
		<form id="filter_form_industrial3" action="<?=$arParams['form_action']?>" method="get">
			<input type="hidden" name="tab" value="3" />
			<input type="hidden" name="view" value="1" />
		<ul class="fParams">
			<!--<li>
				<div class="label">Типоразмер:</div>
				<select name="size_3">
					<?=$arResult['SIZES_3']?>
				</select>
			</li>-->
			<li>
				<div class="label">Категория:</div>
				<select name="type"><option value="tires" <?if($_GET['type']=="tires") echo 'selected="selected"';?>>Камеры</option><option value="lenty" <?if($_GET['type']=="lenty") echo 'selected="selected"';?>>Ободные ленты</option><option value="kolca" <?if($_GET['type']=="kolca") echo 'selected="selected"';?>>Уплотнительные кольца</option></select>
			</li>			
			<!--<li><span class="fNovelty"><input type="checkbox" id="filter-param-1" name="cams"<?=$arResult['cams_checked']?>></span> <label for="filter-param-1">Камеры</label><br><span class="fNovelty"><input type="checkbox" id="filter-param-2" name="tapes"<?=$arResult['tapes_checked']?>></span> <label for="filter-param-2">Ободные ленты</label></li>-->
		</ul>
		<a href="javascript:void(0);" onClick="$(this).parent().reset_form();" class="resetBtn">Сбросить</a>
		<a href="javascript:void(0);" onClick="$('#filter_form_industrial3').submit();" class="btn">Открыть</a>
		</form>
	</div>
	<script>
		$(document).ready(function(){
			$('#filter-industrial-<?=$arParams['filter_id']?>').tabs();
		})
	</script>
</div>
</form>
<div id="industrial_type_hidden_params" style="display:none;"></div>
<script type="text/javascript">
$(function() {
    <?

    if($_GET['tab'] == 1) echo '$("#ui-id-1").trigger("click");';
    if($_GET['tab'] == 2) echo '$("#ui-id-2").trigger("click");';
    if($_GET['tab'] == 3) echo '$("#ui-id-3").trigger("click");';

    ?>
});
</script>