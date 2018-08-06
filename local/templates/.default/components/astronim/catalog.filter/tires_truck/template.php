<?
//print_r($_GET);

$view = intval($_GET['view']);

if($arParams['filter_id'] == '') $arParams['filter_id'] = 1;
if($arParams['form_action'] == '') $arParams['form_action'] = '/catalog/tires/car/';

?>
<div class="filter" id="filter-truck-<?=$arParams['filter_id']?>">
	<!--<div class="count">Всего товаров: <b>4 600</b></div>-->
	<div class="title">Подбор товаров</div>
	<ul class="fTabs">
		<li class="ui-tabs-active"><a href="#filter-truck-1-1">По параметрам</a></li>
		<li><a href="#filter-truck-1-2">По cписку типоразмеров</a></li>
		<li><a href="#filter-truck-1-3">Грузовые диски</a></li>
		<li><a href="#filter-truck-1-4">Грузовые камеры</a></li>
		<li><a href="#filter-truck-1-5">Ободные ленты</a></li>
	</ul>
	<div class="filterBlock" id="filter-truck-1-1">
		<form id="filter_form_truck1" action="<?=$arParams['form_action']?>" method="get">
			<input type="hidden" name="tab" value="1" />
			<input type="hidden" name="view" value="<?=$view?>" />
			<ul class="fParams">
				<li>
					<div class="label">Типоразмер:</div>
					<select name="size">
						<?=$arResult['SIZES']?>
					</select>
				</li>
				<li>
					<div class="label">Ось:</div>
					<select name="axis">
						<?=$arResult['AXIS']?>
					</select>
				</li>
				<li>
					<div class="label">Производитель:</div>
					<select name="manufacturer">
						<?=$arResult['MANUFACTURER']?>
					</select>
				</li>
				<li>
					<div class="label">Индекс нагрузки:</div>
					<select name="index">
						<?=$arResult['INDEX']?>
					</select>
				</li>
			</ul>
			<ul class="fParams2">
				<li<? if ($setting_i[0] == 'N') print ' style="display: none;"'; ?>><span class="fNovelty"><input type="checkbox" id="filter-param-6" name="novelty"<?=$arResult['novelty_checked']?>></span> <label for="filter-param-6">Новинки</label></li>
				<li<? if ($setting_i[1] == 'N') print ' style="display: none;"'; ?>><span class="fSpecial"><input type="checkbox" id="filter-param-7" name="special_offer"<?=$arResult['special_offer_checked']?>></span> <label for="filter-param-7">Спецпредложения</label></li>
				<li<? if ($setting_i[2] == 'N') print ' style="display: none;"'; ?>><span class="fDiscount"><input type="checkbox" id="filter-param-8" name="sale"<?=$arResult['sale_checked']?>></span> <label for="filter-param-8">Сниженная цена</label></li>
				
			</ul>
			<a href="javascript:void(0);" onClick="$(this).parent().reset_form();" class="resetBtn">Сбросить</a>
			<a href="javascript:void(0);" onClick="$('#filter_form_truck1').submit();" class="btn">Открыть</a>
		</form>
	</div>
	<div class="filterBlock ui-tabs-hide" id="filter-truck-1-2">
		<form id="filter_form_truck2" action="<?=$arParams['form_action']?>" method="get">
			<input type="hidden" name="tab" value="2" />
			<input type="hidden" name="view" value="<?=$view?>" />
		<div class="fParamsSizes">
			<div class="fSize">
				<div class="label">Типоразмеры по диаметру: <span class="chosenSize"><?=$arResult['CHOSEN_SIZE']?></span><input type="hidden" name="chosenSize" value="<?=$arResult['CHOSEN_SIZE']?>" /></div>
				<ul class="fSizes">
					<?=$arResult['SIZES2']?>
				</ul>
			</div>
			<ul class="fParams">
				<li>
					<div class="label">Ось:</div>
						<select name="axis">
							<?=$arResult['AXIS']?>
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
			</ul>
		</div>
		<ul class="fParams fParamsCheckbox">
			<li>
				<noindex>
					<div class="sel_unsel"><a href="" class="sel">Выделить всё</a><!-- / <a href="" class="un_sel">Снять всё</a>--></div>
				</noindex>
				<div class="label">Производитель:</div>
				<?php foreach ($arResult['MANUFACTURER_ARRAY'] as $k=>$v) : ?>
				<label><input type="checkbox" name="manufacturer[]" value="<?=$k?>" <?php echo in_array($v, $_REQUEST['manufacturer']) ? 'checked' : '' ?>><?=$v?></label>
				<?php endforeach ?>
			</li>
			
		</ul>
		<div class="clear"><!-- --></div>
		<a href="javascript:void(0);" onClick="$(this).parent().reset_form();" class="resetBtn">Сбросить</a>
		<a href="javascript:void(0);" onClick="$('#filter_form_truck2').submit();" class="btn">Открыть</a>
		</form>
	</div>
	<div class="filterBlock ui-tabs-hide" id="filter-truck-1-3">
		<form id="filter_form_truck3" action="<?=$arParams['form_action']?>" method="get">
			<input type="hidden" name="tab" value="3" />
			<input type="hidden" name="view" value="<?=$view?>" />
		<ul class="fParams">
			<li>
				<div class="label">Типоразмер:</div>
				<select name="size">
					<?=$arResult['DISK_SIZES']?>
				</select>
			</li>
		</ul>
		<a href="javascript:void(0);" onClick="$(this).parent().reset_form();" class="resetBtn">Сбросить</a>
		<a href="javascript:void(0);" onClick="$('#filter_form_truck3').submit();" class="btn">Открыть</a>
		</form>
	</div>
	<div class="filterBlock ui-tabs-hide" id="filter-truck-1-4">
		<form id="filter_form_truck4" action="<?=$arParams['form_action']?>" method="get">
			<input type="hidden" name="tab" value="4" />
			<input type="hidden" name="view" value="<?=$view?>" />
		<ul class="fParams">
			<li>
				<div class="label">Типоразмер:</div>
				<select name="size">
					<?=$arResult['CAMS_SIZES']?>
				</select>
			</li>
		</ul>
		<a href="javascript:void(0);" onClick="$(this).parent().reset_form();" class="resetBtn">Сбросить</a>
		<a href="javascript:void(0);" onClick="$('#filter_form_truck4').submit();" class="btn">Открыть</a>
		</form>
	</div>
	<div class="filterBlock ui-tabs-hide" id="filter-truck-1-5">
		<form id="filter_form_truck5" action="<?=$arParams['form_action']?>" method="get">
			<input type="hidden" name="tab" value="5" />
			<input type="hidden" name="view" value="<?=$view?>" />
		<ul class="fParams">
			<li>
				<div class="label">Типоразмер:</div>
				<select name="size">
					<?=$arResult['LENTY_SIZES']?>
				</select>
			</li>
		</ul>
		<a href="javascript:void(0);" onClick="$(this).parent().reset_form();" class="resetBtn">Сбросить</a>
		<a href="javascript:void(0);" onClick="$('#filter_form_truck5').submit();" class="btn">Открыть</a>
		</form>
	</div>
	<script>
		$(document).ready(function(){
			$('#filter-truck-<?=$arParams['filter_id']?>').tabs();
		})
	</script>
</div>
</form>
<script type="text/javascript">
$(function() {
    var availableTags = [
      <?=$arResult['FAST_SEARCH']?>
    ];
    $( "#fast_search" ).autocomplete({
      source: availableTags, 
      minChars: 2,
      width: 148
    });

    <?

    if($_GET['tab'] == 1) echo '$("#ui-id-1").trigger("click");';
    if($_GET['tab'] == 2) echo '$("#ui-id-2").trigger("click");';
    if($_GET['tab'] == 3) echo '$("#ui-id-3").trigger("click");';
    if($_GET['tab'] == 4) echo '$("#ui-id-4").trigger("click");';
    if($_GET['tab'] == 5) echo '$("#ui-id-5").trigger("click");';

    ?>

});
</script>