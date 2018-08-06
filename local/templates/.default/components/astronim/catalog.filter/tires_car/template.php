<?
//print_r($_GET);

$view = intval($_GET['view']);

if($arParams['filter_id'] == '') $arParams['filter_id'] = 1;
if($arParams['form_action'] == '') $arParams['form_action'] = '/catalog/tires/car/';

?>
<div class="filter" id="filter-<?=$arParams['filter_id']?>">
	<!--<div class="count">Всего товаров: <b>4 600</b></div>-->
	<div class="title">Подбор товаров</div>
	<ul class="fTabs">
		<li <?if($arParams['filter_id'] == 1) echo 'class="ui-tabs-active"'?>><a href="#filter-1-1">По параметрам</a></li>
		<li <?if($arParams['filter_id'] == 2) echo 'class="ui-tabs-active"'?>><a href="#filter-1-2">По cписку типоразмеров</a></li>
		<li <?if($arParams['filter_id'] == 3) echo 'class="ui-tabs-active"'?>><a href="#filter-1-3">По марке авто</a></li>
		<li <?if($arParams['filter_id'] == 4) echo 'class="ui-tabs-active"'?>><a href="#filter-1-4">Легковые камеры</a></li>
	</ul>
	<div class="filterBlock" id="filter-1-1">
		<form id="filter_form1" action="<?=$arParams['form_action']?>" method="get">
			<input type="hidden" id="chained_select_type" value="shini" />
			<input type="hidden" name="tab" value="1" />
			<input type="hidden" name="view" value="<?=$view?>" />
		<ul class="fParams">
			<li>
				<div class="label">Ширина:</div>
				<select name="width" class="chained_select" select_code="shini">
					<?=$arResult['WIDTH']?>
				</select>
			</li>
			<li>
				<div class="label">Профиль:</div>
				<select name="height" class="chained_select" select_code="shini">
					<?=$arResult['HEIGHT']?>
				</select>
			</li>
			<li>
				<div class="label">Диаметр:</div>
				<select name="diametr" class="chained_select" select_code="shini">
					<?=$arResult['DIAMETR']?>
				</select>
			</li>
			<li>
				<div class="label">Сезонность:</div>
				<select name="season" id="season" onchange="ch_a_dis();">
					<?=$arResult['SEASON']?>
				</select>
			</li>
			<li>
				<div class="label">Производитель:</div>
				<select name="manufacturer">
					<?=$arResult['MANUFACTURER']?>
				</select>
			</li>
		</ul>
		
<script type="text/javascript">
	$(document).ready(function() {
		var season = $("#season").val();
		if (season == 'Зимняя'){
			$("#filter-param-20").attr("disabled", true);
			$("#filter-param-22").attr("disabled", true);
		}
	});
</script>

<script type="text/javascript">
	function ch_a_dis(){
		var season = $("#season").val();
		if (season == 'Зимняя'){
			$("#filter-param-20").attr("disabled", true);
			$("#filter-param-22").attr("disabled", true);
		}
		else{
			$("#filter-param-20").attr("disabled", false);
			$("#filter-param-22").attr("disabled", false);
		}
		return false;
	}
</script>
		
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
			$setting_i[$count_i] = $arFields_i["ACTIVE"];
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
			<li><span><input type="checkbox" id="filter-param-4" name="reinforced_tire"<?=$arResult['reinforced_tire_checked']?>></span> <label for="filter-param-4">Усиленная шина (XL/RF)</label></li>
			<li><span><input type="checkbox" id="filter-param-5" name="ostatok"<?=$arResult['ostatok_checked']?>></span> <label for="filter-param-5">В остатках ≥ 4 шт.</label></li>
			<li><span><input type="checkbox" id="filter-param-20" name="ms_tire"<?=$arResult['ms_tire_checked']?>></span> <label for="filter-param-20">M+S</label></li>
			<li><span><input type="checkbox" id="filter-param-22" name="all_seasons"<?=$arResult['all_seasons_checked']?>></span> <label for="filter-param-22">All seasons</label></li>
		</ul>
		<div class="label">Или воспользуйтесь быстрым поиском:</div>
		<div class="fastSearch">
			<input type="text" id="fast_search" name="fast_search" value="<?=$_REQUEST['fast_search']?>">
			<div class="ex">Пример: 215/65 R16</div>
		</div>
		<a href="javascript:void(0);" onClick="$(this).parent().reset_form(); reset_chained_selects('shini');" class="resetBtn">Сбросить</a>
		<a href="javascript:void(0);" onClick="$('#filter_form1').submit();" class="btn">Открыть</a>
		</form>
	</div>
	<div class="filterBlock ui-tabs-hide" id="filter-1-2">
		<form id="filter_form2" action="<?=$arParams['form_action']?>" method="get">
			<input type="hidden" name="tab" value="2" />
			<input type="hidden" name="view" value="<?=$view?>" />
		<div class="fSize">
			<div class="label">Типоразмеры по диаметру: <?
			$str = explode('/',$arResult['CHOSEN_SIZE']);
			if($str[0] == ''){ $CHOSEN_SIZE = $str[1]; } else { $CHOSEN_SIZE = $arResult['CHOSEN_SIZE']; }
			?><span class="chosenSize"><?=$CHOSEN_SIZE?></span><input type="hidden" name="chosenSize" value="<?=$arResult['CHOSEN_SIZE']?>" /></div>
			<ul class="fSizes">
				<?=$arResult['SIZES']?>
			</ul>
		</div>
		<ul class="fParams2">
			<li<? if ($setting_i[0] == 'N') print ' style="display: none;"'; ?>><span class="fNovelty"><input type="checkbox" id="filter-param-6" name="novelty"<?=$arResult['novelty_checked']?>></span> <label for="filter-param-6">Новинки</label></li>
			<li<? if ($setting_i[1] == 'N') print ' style="display: none;"'; ?>><span class="fSpecial"><input type="checkbox" id="filter-param-7" name="special_offer"<?=$arResult['special_offer_checked']?>></span> <label for="filter-param-7">Спецпредложения</label></li>
			<li<? if ($setting_i[2] == 'N') print ' style="display: none;"'; ?>><span class="fDiscount"><input type="checkbox" id="filter-param-8" name="sale"<?=$arResult['sale_checked']?>></span> <label for="filter-param-8">Сниженная цена</label></li>
			<li><span><input type="checkbox" id="filter-param-9" name="reinforced_tire"<?=$arResult['reinforced_tire_checked']?>></span> <label for="filter-param-9">Усиленная шина (XL/RF)</label></li>
			<li><span><input type="checkbox" id="filter-param-10" name="ostatok"<?=$arResult['ostatok_checked']?>></span> <label for="filter-param-10">В остатках ≥ 4 шт.</label></li>
			<li><span><input type="checkbox" id="filter-param-21" name="ms_tire"<?=$arResult['ms_tire_checked']?>></span> <label for="filter-param-21">M+S</label></li>
			<li><span><input type="checkbox" id="filter-param-23" name="all_seasons"<?=$arResult['all_seasons_checked']?>></span> <label for="filter-param-23">All seasons</label></li>
		</ul>
		<ul class="fParams">
			<li>
				<div class="label">Сезонность:</div>
				<select name="season">
					<?=$arResult['SEASON']?>
				</select>
			</li>
			<li>
				<div class="label">Производитель:</div>
				<select name="manufacturer">
					<?=$arResult['MANUFACTURER']?>
				</select>
			</li>
		</ul>
		<a href="javascript:void(0);" onClick="$(this).parent().reset_form(); reser_chained_selects();" class="resetBtn">Сбросить</a>
		<a href="javascript:void(0);" onClick="$('#filter_form2').submit();" class="btn">Открыть</a>
		</form>
	</div>
	<div class="filterBlock ui-tabs-hide" id="filter-1-3">
		<form id="filter_form3" type="tires_car" action="<?=$arParams['form_action']?>" method="get">
			<input type="hidden" class="chained_select_db_type" id="chained_select_db_type" value="tires_car" />
			<input type="hidden" name="tab" value="3" />
			<input type="hidden" name="prop_mark" props_code="tires_car" in_order="yes" value="<?=$arResult['mark_filter']['mark']?>" />
			<input type="hidden" name="prop_model" props_code="tires_car" in_order="yes" value="<?=$arResult['mark_filter']['model']?>" />
			<input type="hidden" name="prop_year" props_code="tires_car" in_order="yes" value="<?=$arResult['mark_filter']['year']?>" />
			<input type="hidden" name="prop_modification" props_code="tires_car" in_order="yes" value="<?=$arResult['mark_filter']['modification']?>" />
			<input type="hidden" name="prop_size" props_code="tires_car" in_order="no" value="<?=$arResult['mark_filter']['size']?>" /> 
			<input type="hidden" name="view" value="<?=$view?>" /> 
			<ul class="fParams">
				<li>
					<div class="label">Марка:</div>
					<select name="mark" class="chained_select_db forward_select" order="1" pos="first" default="Любая" select_code="tires_car"> 
						<?=$arResult['mark']?>
					</select>				
				</li>
				<li>
					<div class="label"><span id="tires_car_loader_2" style="display:none"><img src="http://bagoria.by/bitrix/templates/bagoria/i/loader.gif"></span> Модель:</div>
					<select name="model" class="chained_select_db forward_select <? if($arResult['mark_filter']['model'] == '') echo 'disabled';?>" order="2" pos="inside" default="Любая" select_code="tires_car" <? if($arResult['mark_filter']['model'] == '') echo 'disabled="disabled"';?>>   
						<?=$arResult['model']?>
					</select>				
				</li>			
				<li>
					<div class="label"><span id="tires_car_loader_3" style="display:none"><img src="http://bagoria.by/bitrix/templates/bagoria/i/loader.gif"></span> Год выпуска:</div>
					<select name="year" class="chained_select_db forward_select <? if($arResult['mark_filter']['model'] == '') echo 'disabled';?>" order="3" pos="inside" default="Любой" select_code="tires_car" <? if($arResult['mark_filter']['model'] == '') echo 'disabled="disabled"';?>> 
						<?=$arResult['year']?>
					</select>				
				</li>
				<li> 
					<div class="label"><span id="tires_car_loader_4" style="display:none"><img src="http://bagoria.by/bitrix/templates/bagoria/i/loader.gif"></span> Модификация:</div>
					<select name="modification" class="chained_select_db forward_select <? if($arResult['mark_filter']['model'] == '') echo 'disabled';?>" order="4" pos="inside" default="Любая" select_code="tires_car" <? if($arResult['mark_filter']['model']  == '') echo 'disabled="disabled"';?>> 
						<?=$arResult['modification']?>
					</select>				
				</li>					
				<li> 
					<div class="label"><span id="tires_car_loader_5" style="display:none"><img src="http://bagoria.by/bitrix/templates/bagoria/i/loader.gif"></span> Типоразмер:</div>
					<select name="size" class="chained_select_db forward_select groups <? if($arResult['mark_filter']['model'] == '') echo 'disabled';?>" order="5" pos="last" default="Любой" select_code="tires_car" tires_car="tires_car" group_name_1="Заводской" group_name_2="Замена" group_name_3="Тюнинг" <? if($arResult['mark_filter']['model'] == '') echo 'disabled="disabled"';?>>
						<?=$arResult['size']?>			
					</select>				
				</li>							
			</ul>
		<a href="javascript:void(0);" onClick="$(this).parent().reset_form(); reset_chained_selects_db();" class="resetBtn">Сбросить</a>
		<a href="javascript:void(0);" onClick="check_chained_select('filter_form3')" type="tires_car" class="btn disabled">Открыть</a> <!-- $('#filter_form3').submit(); -->
		</form>
	</div>
	<div class="filterBlock ui-tabs-hide" id="filter-1-4">
		<form id="filter_form4" action="<?=$arParams['form_action']?>" method="get">
			<input type="hidden" name="tab" value="4" />
			<input type="hidden" name="view" value="<?=$view?>" />
		<ul class="fParams">
			<li>
				<div class="label">Категория:</div>
				<select name="cams_category">
					<?=$arResult['CAMS_CATEGORY']?>
				</select>
				<!--
				<div class="label">Производитель:</div>
				<select name="cams_manufacturer">
					<?=$arResult['CAMS_MANUFACTURER']?>
				</select>
				-->
			</li>
			<li>
				<div class="label">Диаметр:</div>
				<select name="cams_diametr">
					<?=$arResult['CAMS_DIAMETR']?>
				</select>
				<!--
				<div class="label">Производитель:</div>
				<select name="cams_manufacturer">
					<?=$arResult['CAMS_MANUFACTURER']?>
				</select>
				-->
			</li>			
		</ul>
		<a href="javascript:void(0);" onClick="$(this).parent().reset_form();" class="resetBtn">Сбросить</a>
		<a href="javascript:void(0);" onClick="$('#filter_form4').submit();" class="btn">Открыть</a>
		</form>
	</div>
	<script>
		$(document).ready(function(){
			$('#filter-<?=$arParams['filter_id']?>').tabs();
		})
	</script>
</div>
</form>
<style text="text/css">
.ui-autocomplete {
	background-color: white;
	border: 1px solid #707070;
	border-top:0;
	max-width: 148px;
}
.ui-autocomplete li {
	padding: 3px 5px;
}
.ui-autocomplete li a {
	cursor: pointer;
}
.ui-helper-hidden-accessible {
	display: none !important;
}
</style>
<script type="text/javascript">
$(function() {
    var availableTags = [
      <?=$arResult['FAST_SEARCH']?>
    ];
    $( "#fast_search" ).autocomplete({
      source: availableTags, 
      minLength: 2,
      width: 148
    });

    <?

    if($_GET['tab'] == 1) echo '$("#ui-id-1").trigger("click");';
    if($_GET['tab'] == 2) echo '$("#ui-id-2").trigger("click");';
    if($_GET['tab'] == 4) echo '$("#ui-id-4").trigger("click");';
   // if($_GET['tab'] == 3) echo '$("#ui-id-3").trigger("click");';
   // if($_GET['tab'] == 4) echo '$("#ui-id-4").trigger("click");';

    ?>

});
</script>