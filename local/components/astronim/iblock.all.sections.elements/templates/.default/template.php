<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
?>

<div class="map-container">
    <div class="map js-map">
        <?foreach ($arResult['SECTIONS'] as $id => $item){?>
            <div class="map-item" id="map-<?=$item['ID']?>">
            </div>
        <?}?>
    </div>
    <div class="map-info js-map-info">
        <?foreach ($arResult['SECTIONS'] as $id => $item){?>
            <a href="#" class="header <?if($i++ == 0){?>active<?}?>"><span><?=$item['NAME']?></span></a>
            <div class="map-info-item">
                <?=$item['DESCRIPTION']?>
            </div>
        <?}?>
    </div>
</div>
<script data-skip-moving="true"
        src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"
        type="text/javascript"></script>
<script data-skip-moving="true"
        type="text/javascript">
<?foreach ($arResult['SECTIONS'] as $id => $section){?>
    ymaps.ready(init<?=$section['ID']?>);
<?}?>


<?foreach ($arResult['SECTIONS'] as $id => $section){?>
    function init<?=$section['ID']?> (){
        var myMap_<?=$section['ID']?> = new ymaps.Map("map-<?=$section['ID']?>", {
            center: [<?=$section['UF_COORDINATES']?>],
            zoom: <?=$section['UF_ZOOM']?>,
            controls: ['smallMapDefaultSet']
        });

        <?foreach ($section['ITEMS'] as $item){?>
            var myPlacemark_<?=$item['ID']?> = new ymaps.Placemark([<?=$item['PROPERTY_COORDINATES_VALUE']?>], {
                hintContent: <?=CUtil::PhpToJSObject($item['NAME'])?>,
                balloonContent: <?=CUtil::PhpToJSObject($item['PREVIEW_TEXT'])?>
            }, {
                iconLayout: 'default#image',
                iconImageHref: '/local/templates/.default/i/icons/map-label.png',
                iconImageSize: [98, 77],
                iconImageOffset: [-22, -77]
            });

            myMap_<?=$section['ID']?>.geoObjects.add(myPlacemark_<?=$item['ID']?>);
        <?}?>

        myMap_<?=$section['ID']?>.behaviors.disable('scrollZoom');
    }
<?}?>
</script>