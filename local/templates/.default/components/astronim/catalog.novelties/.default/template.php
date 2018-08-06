<? //print_r($arResult['ITEMS']); ?>
<? if(count($arResult['ITEMS'])>0): ?>
<div class="novelties">
	<div class="title">Новинки<?//echo count($arResult['ITEMS']);?></div>
	<ul class="products2">
		<? foreach($arResult['ITEMS'] as $row): ?>
			<li>
				<a href="<?=$arResult['CATEGORY']?>/?view=3&manufacturer=<? echo urlencode($row['PROPERTY_PROIZVODITEL_VALUE'])?>&model=<? echo urlencode($row['PROPERTY_MODEL_VALUE'])?>">
					<div class="pic">
						<? echo get_item_photo($row['PREVIEW_PICTURE']) ?>
						<!--<img src="i/img02.jpg" alt="<?=$row['PROPERTY_PROIZVODITEL_VALUE']?> <?=$row['PROPERTY_MODEL_VALUE']?>" width="72" height="108">-->
					</div>
					<?=$row['PROPERTY_PROIZVODITEL_VALUE']?> <?=$row['PROPERTY_MODEL_VALUE']?>
				</a>
			</li>
		<? endforeach; ?>
	</ul>
</div>
<?endif;?>