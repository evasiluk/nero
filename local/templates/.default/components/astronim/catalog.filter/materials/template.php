<?
//print_r($_GET);

$view = intval($_GET['view']);

if($arParams['filter_id'] == '') $arParams['filter_id'] = 1;
if($arParams['form_action'] == '') $arParams['form_action'] = '/catalog/materials/'; 

?>
<div class="filter" id="filter-materials-<?=$arParams['filter_id']?>">
	<!--<div class="count">Всего товаров: <b>4 600</b></div>-->
	<div class="title">Подбор товаров</div>
	<ul class="fTabs">
		<li <?if($_REQUEST['tab']==1 or !isset($_REQUEST['tab'])) echo 'class="ui-tabs-active"';?>><a href="#filter-materials-1-1">По параметрам</a></li> 
		<?/*
		<li <?if($_REQUEST['tab']==1 or !isset($_REQUEST['tab'])) echo 'class="ui-tabs-active"';?>><a href="#filter-materials-1-1">По параметрам</a></li>
		<li <?if($_REQUEST['tab']==3) echo 'class="ui-tabs-active"';?>><a href="#filter-materials-1-2">По марке авто</a></li>
		*/?>
	</ul>
	<div class="filterBlock ui-tabs-hide" id="filter-materials-1-1">
		<form id="filter_form_materials1" action="<?=$arParams['form_action']?>" method="get">
			<input type="hidden" name="tab" value="1" />
			<input type="hidden" name="view" value="<?=$view?>" />
		<ul class="fParams">
			<li>
				<div class="label">Категория:</div>
				<select name="category">
					<?=$arResult['CATEGORY']?>
				</select>
			</li>
			<li>
				<div class="label">Поиск по модели:</div>
				<div class="fastSearch">
					<input type="text" id="model" name="model" value="<?=$_REQUEST['model']?>">
				</div>
			</li>
		</ul>
		<a href="javascript:void(0);" onClick="$(this).parent().reset_form();" class="resetBtn">Сбросить</a>
		<a href="javascript:void(0);" onClick="$('#filter_form_materials1').submit();" class="btn">Открыть</a>
		</form>
	</div>	
	<script>
		$(document).ready(function(){
			$('#filter-materials-<?=$arParams['filter_id']?>').tabs();
		})
	</script>
</div>
</form>
<script type="text/javascript">
$(function() {

    <?

    if($_GET['tab'] == 1) echo '$("#ui-id-1").trigger("click");';

    ?>

});
</script>