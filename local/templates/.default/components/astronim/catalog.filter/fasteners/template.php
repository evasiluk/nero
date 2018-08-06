<?
//print_r($SAFE_REQUEST);

$SAFE_REQUEST = array();

foreach($_GET as $key => $value){

	$SAFE_REQUEST[$key] = htmlspecialcharsbx($value);

}

//$SAFE_REQUEST = noCrossSiteScripting($_GET);

$view = intval($SAFE_REQUEST['view']);

if($arParams['filter_id'] == '') $arParams['filter_id'] = 1;
if($arParams['form_action'] == '') $arParams['form_action'] = '/catalog/materials/';

?>
<div class="filter" id="filter-fasteners-<?=$arParams['filter_id']?>">
	<!--<div class="count">Всего товаров: <b>4 600</b></div>-->
	<div class="title">Подбор товаров</div>
	<ul class="fTabs">
		<li class="ui-tabs-active"><a href="#filter-fasteners-1-1">Быстрый поиск</a></li>
		<li><a href="#filter-fasteners-1-2">По параметрам</a></li>
	</ul>
	<div class="filterBlock" id="filter-fasteners-1-1">
		<form id="filter_form_fasteners1" action="<?=$arParams['form_action']?>" method="get">
			<input type="hidden" name="tab" value="1" />
			<input type="hidden" name="view" value="<?=$view?>" />
		<div class="label">Наименование:</div>
		<div class="fastSearch">
			<input type="text" id="name" name="name" style="width: 280px;" value="<?=$SAFE_REQUEST['name']?>">
			<div class="ex">Пример: Гайка</div>
		</div>
		<a href="javascript:void(0);" onClick="$(this).parent().reset_form();" class="resetBtn">Сбросить</a>
		<a href="javascript:void(0);" onClick="$('#filter_form_fasteners1').submit();" class="btn">Открыть</a>
		</form>
	</div>
	<div class="filterBlock ui-tabs-hide" id="filter-fasteners-1-2">
		<form id="filter_form_fasteners2" action="<?=$arParams['form_action']?>" method="get">
			<input type="hidden" name="tab" value="2" />
			<input type="hidden" name="view" value="<?=$view?>" />
		<ul class="fParams">
			<li>
				<div class="label">Категория:</div>
				<select name="category">
					<?=$arResult['CATEGORY']?>
				</select>
			</li>
			<li>
				<div class="label">Производитель:</div>
				<select name="manufacturer">
					<?=$arResult['MANUFACTURER']?>
				</select>
			</li>
		</ul>
		<a href="javascript:void(0);" onClick="$(this).parent().reset_form();" class="resetBtn">Сбросить</a>
		<a href="javascript:void(0);" onClick="$('#filter_form_fasteners2').submit();" class="btn">Открыть</a>
		</form>
	</div>
	<script>
		$(document).ready(function(){
			$('#filter-fasteners-<?=$arParams['filter_id']?>').tabs();
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
      <?=$arResult['NAMES']?>
    ];
    $( "#name" ).autocomplete({
      source: availableTags, 
      minChars: 2,
      width: 148
    });

    <?

    if($SAFE_REQUEST['tab'] == 1) echo '$("#ui-id-1").trigger("click");';
    if($SAFE_REQUEST['tab'] == 2) echo '$("#ui-id-2").trigger("click");';
    if($SAFE_REQUEST['tab'] == 3) echo '$("#ui-id-3").trigger("click");';
    if($SAFE_REQUEST['tab'] == 4) echo '$("#ui-id-4").trigger("click");';

    ?>

});
</script>