<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
foreach ($arResult["ITEMS"] as &$arItem) {
    if ($video = $arItem["PROPERTIES"]["youtube"]["VALUE"]) {
        if(strpos($video, 'youtube.com/watch') !== false){
            parse_str(
                parse_url($video, PHP_URL_QUERY),
                $arQuery
            );
            $arItem["PROPERTIES"]["youtube"]["ut_id"] = $arQuery['v'];
        } elseif(strpos($video, 'youtube.com/embed/') !== false){
            preg_match("/youtube\.com\/embed\/([^\?]*)/", $video, $out);
            $arItem["PROPERTIES"]["youtube"]["ut_id"] = $out[1];

        } elseif(strpos($video, 'youtu.be/') !== false){
            preg_match("/youtu\.be\/([^\?]*)/", $video, $out);
            $arItem["PROPERTIES"]["youtube"]["ut_id"] = $out[1];

        } else continue;
        $arItem["PROPERTIES"]["youtube"]["preview"] = "//img.youtube.com/vi/{$arItem["PROPERTIES"]["youtube"]["ut_id"]}/hqdefault.jpg";
        $arItem["PROPERTIES"]["youtube"]["src"] = "//www.youtube.com/embed/{$arItem["PROPERTIES"]["youtube"]["ut_id"]}?rel=0&controls=0&showinfo=0";
    }
    foreach ($arItem["PROPERTIES"]["file"]["VALUE"] as $key => &$file) {
        $file = CFile::GetFileArray($file);
    }
}