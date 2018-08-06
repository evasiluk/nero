<?

/**
 * Форматируем размер шины
 * @param int $a - ширина
 * @param int $b - высота
 * @param int $c - диаметр
 * @return string
 */
function formatSize($a,$b,$c) 
{
	return $a."/".$b."R".$c;
}

/**
 * Форматируем индекс
 * @param int $a - индекс нагрузки
 * @param string $b - индекс скорости
 * @return string
 */
function formatIndex($a,$b)
{
	return $a.$b;
}

function formatPrice($price)
{
	$price = str_replace(".00", "", $price);
	$price = @number_format($price, 0, '', ' ');
	return $price;
}

function formUrl($np)
{
	$params = array();
	$result = array();
	$uri = explode("?", $_SERVER['REQUEST_URI']);
	$blocks = explode("&", $uri[1]);
	foreach($blocks as $value)
	{
		$exp = explode("=", $value);
		$params[$exp[0]] = $exp[1];
	}
	foreach($np as $k=>$v)
	{
		$params[$k] = $v;
	}
	foreach($params as $k=>$v)
	{
		if($k != '') $result[] = $k.'='.$v;
	}

	if (count($result) > 0)
	{
		return "?".implode("&",$result);
	} else {
		return "";
	}
}


?>
<h1>Легковые шины</h1>
<div class="filter" id="filter-1">
	<div class="count">Всего товаров: <b>4 600</b></div>
	<div class="title">Подбор товаров</div>
	<ul class="fTabs">
		<li class="ui-tabs-active"><a href="#filter-1-1">По параметрам</a></li>
		<li><a href="#filter-1-2">По cписку типоразмеров</a></li>
		<li><a href="#filter-1-3">По марке авто</a></li>
		<li><a href="#filter-1-4">Легковые камеры</a></li>
	</ul>
	<div class="filterBlock" id="filter-1-1">
		<ul class="fParams">
			<li>
				<div class="label">Ширина:</div>
				<select>
					<option>Любая</option>
				</select>
			</li>
			<li>
				<div class="label">Профиль:</div>
				<select>
					<option>Любая</option>
				</select>
			</li>
			<li>
				<div class="label">Диаметр:</div>
				<select>
					<option>Любая</option>
				</select>
			</li>
			<li>
				<div class="label">Сезонность:</div>
				<select>
					<option>Любая</option>
				</select>
			</li>
			<li>
				<div class="label">Производитель:</div>
				<select>
					<option>Выберите из списка</option>
				</select>
			</li>
		</ul>
		<ul class="fParams2">
			<li><span class="fNovelty"><input type="checkbox" id="filter-param-1"></span> <label for="filter-param-1">Новинки</label></li>
			<li><span class="fSpecial"><input type="checkbox" id="filter-param-2"></span> <label for="filter-param-2">Спецпредложения</label></li>
			<li><span class="fDiscount"><input type="checkbox" id="filter-param-3"></span> <label for="filter-param-3">Сниженная цена</label></li>
			<li><span><input type="checkbox" id="filter-param-4"></span> <label for="filter-param-4">Усиленная шина (XL/RF)</label></li>
			<li><span><input type="checkbox" id="filter-param-5"></span> <label for="filter-param-5">В остатках ≥ 4 шт.</label></li>
		</ul>
		<div class="label">Или воспользуйтесь быстрым поиском:</div>
		<div class="fastSearch">
			<input type="text">
			<div class="ex">Пример: 215/65 R16</div>
		</div>
		<a href="#" class="btn">Открыть</a>
	</div>
	<div class="filterBlock ui-tabs-hide" id="filter-1-2">
		<div class="fSize">
			<div class="label">Типоразмеры по диаметру: <span class="chosenSize">&nbsp;</span></div>
			<ul class="fSizes">
				<li><span class="size">R13</span>
					<ul>
						<li><a href="#">155/65 R13</a></li>
						<li><a href="#">155/65 R13</a></li>
						<li><a href="#">155/65 R13</a></li>
					</ul>
				</li>
				<li><span class="size">R14</span>
					<ul>
						<li><a href="#">155/65 R14</a></li>
						<li><a href="#">155/65 R14</a></li>
						<li><a href="#">155/65 R14</a></li>
					</ul>
				</li>
				<li><span class="size">R15</span>
					<ul>
						<li><a href="#">155/65 R15</a></li>
						<li><a href="#">155/65 R15</a></li>
						<li><a href="#">155/65 R15</a></li>
					</ul>
				</li>
				<li><span class="size">R16</span>
					<ul>
						<li><a href="#">155/65 R16</a></li>
						<li><a href="#">155/65 R16</a></li>
						<li><a href="#">155/65 R16</a></li>
					</ul>
				</li>
				<li><span class="size">R17</span>
					<ul>
						<li><a href="#">155/65 R17</a></li>
						<li><a href="#">155/65 R17</a></li>
						<li><a href="#">155/65 R17</a></li>
					</ul>
				</li>
				<li><span class="size">R18</span>
					<ul>
						<li><a href="#">155/65 R18</a></li>
						<li><a href="#">155/65 R18</a></li>
						<li><a href="#">155/65 R18</a></li>
					</ul>
				</li>
				<li><span class="size">R19</span>
					<ul>
						<li><a href="#">155/65 R19</a></li>
						<li><a href="#">155/65 R19</a></li>
						<li><a href="#">155/65 R19</a></li>
					</ul>
				</li>
			</ul>
		</div>
		<ul class="fParams2">
			<li><span class="fNovelty"><input type="checkbox" id="filter-param-6"></span> <label for="filter-param-6">Новинки</label></li>
			<li><span class="fSpecial"><input type="checkbox" id="filter-param-7"></span> <label for="filter-param-7">Спецпредложения</label></li>
			<li><span class="fDiscount"><input type="checkbox" id="filter-param-8"></span> <label for="filter-param-8">Сниженная цена</label></li>
			<li><span><input type="checkbox" id="filter-param-9"></span> <label for="filter-param-9">Усиленная шина (XL/RF)</label></li>
			<li><span><input type="checkbox" id="filter-param-10"></span> <label for="filter-param-10">В остатках ≥ 4 шт.</label></li>
		</ul>
		<ul class="fParams">
			<li>
				<div class="label">Сезонность:</div>
				<select>
					<option>Любая</option>
				</select>
			</li>
			<li>
				<div class="label">Производитель:</div>
				<select>
					<option>Выберите из списка</option>
				</select>
			</li>
		</ul>
		<a href="#" class="btn">Открыть</a>
	</div>
	<div class="filterBlock ui-tabs-hide" id="filter-1-3">
		<ul class="fParams">
			<li>
				<div class="label">Производитель:</div>
				<select>
					<option>Выберите из списка</option>
				</select>
			</li>
		</ul>
		<a href="#" class="btn">Открыть</a>
	</div>
	<div class="filterBlock ui-tabs-hide" id="filter-1-4">
		<ul class="fParams">
			<li>
				<div class="label">Производитель:</div>
				<select>
					<option>Выберите из списка</option>
				</select>
			</li>
		</ul>
		<a href="#" class="btn">Открыть</a>
	</div>
	<script>
		$(document).ready(function(){
			$('#filter-1').tabs();
		})
	</script>
</div>
<div class="pagination">
	<ul class="display">
		<li>Показывать:</li>
<?
foreach($arResult['COUNT_LIST'] as $count)
{
	if($_GET['count'] == $count OR ($_GET['count'] == '' AND $count == 15))
	{
		echo '<li class="current">'.$count.'</li>';
	} else {
		echo '<li><a href="/catalog/tires/car/'.formUrl(array('count'=>$count)).'">'.$count.'</a></li>';
	}
}
?>
	</ul>
	<ul class="view">
		<li>Вид:</li>
		<li><a href="catalogue-1.html"><img src="/bitrix/templates/bagoria/i/rows.png" alt="Таблицей"></a></li>
		<li class="current"><img src="/bitrix/templates/bagoria/i/grid.png" alt="Сеткой"></li>
	</ul>
	<ul class="paging">
		<li>Страницы:</li>
		<li class="current">1</li>
		<li><a href="#">2</a></li>
		<li><a href="#">3</a></li>
		<li><a href="#">4</a></li>
		<li><a href="#">5</a></li>
		<li class="next"><a href="#">»</a></li>
	</ul>
</div>
<div class="currentDiscount"><div class="currentDiscountIn">
	Ваша скидка: <strong>0%</strong> <a href="#" class="changeLink">Изменить</a>
</div></div>
<ul class="productsGrid">

<?
foreach($arResult['ITEMS'] as $row):
?>
	<li>
		<div class="pic">
			<a href="/catalog/tires/car/<?=$row['ID']?>">
				<img src="/bitrix/templates/bagoria/i/img13.jpg" alt="" width="100" height="150">
			</a>
		</div>
		<ul class="features">
			<li>Тип: <img src="/bitrix/templates/bagoria/i/car.png" alt=""></li>
			<li>Типоразмер: <strong><? echo formatSize($row['PROPERTY_SHIRINASHINADISK_VALUE'], $row['PROPERTY_SERIYASHINA_VALUE'], $row['PROPERTY_DIAMETRSHINADISK_VALUE']) ?></strong></li>
			<li>Индекс: <strong><? echo formatIndex($row['PROPERTY_INDEKSNAGRUZKI_VALUE'], $row['PROPERTY_INDEKSSKOROSTI_VALUE']) ?></strong></li>
			<li>Сезон: <? if($row['PROPERTY_RISUNOKPROTEKTORA_VALUE'] == "Зимний"): ?><img src="/bitrix/templates/bagoria/i/winter.png" alt="Зима"><? else: ?><img src="/bitrix/templates/bagoria/i/summer.png" alt="Лето"><? endif; ?></li>
			<li class="brand"><img src="/bitrix/templates/bagoria/i/premiorri.png" alt="Premiorri"></li>
		</ul>
		<div class="caption">
			<div class="price">Цена: <br><strong><? echo formatPrice($row['PRICE']) ?></strong> руб.</div>
			<a href="/catalog/tires/car/<?=$row['ID']?>"><? echo $row['PROPERTY_PROIZVODITEL_VALUE']." ".$row['PROPERTY_MODEL_VALUE'] ?></a>
		</div>
		<table>
<?
if( is_array($row['STORE']) AND count($row['STORE']) > 0):
	foreach($row['STORE'] as $store):
		if($store['AMOUNT'] == 0) continue;
?>
	<tr>
		<td><!--Остаток --><?=$store['STORE_NAME']?>: <!--&gt;--><strong><?=$store['AMOUNT']?></strong></td>
		<td>Заказать:</td>
		<td><input type="text"></td>
		<td><a href="#" class="cartBtn" title="Добавить в корзину">Добавить в корзину</a></td>
	</tr>
<? endforeach;  endif; ?>
		</table>
	</li>
<?
endforeach;
?>
	
</ul>