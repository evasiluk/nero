<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
foreach ($arResult["ITEMS"] as &$arItem) {
    if ($video = $arItem["PROPERTIES"]["video"]["VALUE"]) {
        if(strpos($video, 'youtube.com/watch') !== false){
            parse_str(
                parse_url($video, PHP_URL_QUERY),
                $arQuery
            );
            $arItem["PROPERTIES"]["video"]["ut_id"] = $arQuery['v'];
        } elseif(strpos($video, 'youtube.com/embed/') !== false){
            preg_match("/youtube\.com\/embed\/([^\?]*)/", $video, $out);
            $arItem["PROPERTIES"]["video"]["ut_id"] = $out[1];

        } elseif(strpos($video, 'youtu.be/') !== false){
            preg_match("/youtu\.be\/([^\?]*)/", $video, $out);
            $arItem["PROPERTIES"]["video"]["ut_id"] = $out[1];

        } else continue;
        $arItem["PROPERTIES"]["video"]["preview"] = "//img.youtube.com/vi/{$arItem["PROPERTIES"]["video"]["ut_id"]}/hqdefault.jpg";
        $arItem["PROPERTIES"]["video"]["src"] = "//www.youtube.com/watch?v={$arItem["PROPERTIES"]["video"]["ut_id"]}";
    }
}