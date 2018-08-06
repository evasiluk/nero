<?use Astronim\Helper;?>

<header class="l-header<?Helper::showContent('header_class');?>">
    <div class="header-col">
        <?if($APPLICATION->GetCurDir() == SITE_DIR){?>
            <span class="logo">
                    <svg class="ico-logo" viewBox="0 0 380.6 76.2">
                        <use xlink:href="#ico-logo"></use>
                    </svg>
                </span>
        <?} else {?>
            <a href="<?=SITE_DIR?>" class="logo">
                <svg class="ico-logo" viewBox="0 0 380.6 76.2">
                    <use xlink:href="#ico-logo"></use>
                </svg>
            </a>
        <?}?>
    </div>
    <div class="header-col">
        <div class="menu-button js-menu-toggle">
            <div class="ico-menu">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>
        </div>
    </div>
    <div class="header-col">
        <?$APPLICATION->IncludeComponent(
            "bitrix:menu",
            "top",
            Array(
                "ALLOW_MULTI_SELECT" => "N",
                "CHILD_MENU_TYPE" => "left",
                "DELAY" => "N",
                "MAX_LEVEL" => "2",
                "MENU_CACHE_GET_VARS" => array(""),
                "MENU_CACHE_TIME" => "3600",
                "MENU_CACHE_TYPE" => "N",
                "MENU_CACHE_USE_GROUPS" => "Y",
                "ROOT_MENU_TYPE" => "top",
                "USE_EXT" => "Y"
            )
        );?>
    </div>

    <div class="topnav-catalog" id="topnav-catalog">

        <?Astronim\Helper::includeFile('template/header/catalog_menu')?>

    </div>

    <!-- 	<div class="header-col">
            <a href="#" class="h-ico h-search">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="394.7px" height="394.7px" viewBox="282.6 26.6 394.7 394.7" enable-background="new 282.6 26.6 394.7 394.7" xml:space="preserve">
                <path d="M677.4,396L577.1,295.8c52.2-64.9,48.3-160.4-12-220.7c-31.3-31.3-72.8-48.5-117-48.5
                    c-44.2,0-85.8,17.2-117,48.5c-31.3,31.3-48.5,72.8-48.5,117s17.2,85.8,48.5,117c31.3,31.3,72.8,48.5,117,48.5  c38.2,0,74.4-12.9,103.7-36.5L652,421.3L677.4,396z M448.1,321.8c-34.6,0-67.2-13.5-91.7-38c-24.5-24.5-38-57-38-91.7
                    s13.5-67.2,38-91.7c24.5-24.5,57-38,91.7-38c34.6,0,67.2,13.5,91.7,38c50.5,50.5,50.5,132.8,0,183.3
                    C515.3,308.3,482.8,321.8,448.1,321.8z"/>
                </svg>
            </a>
        </div>
        <div class="header-col">
            <a href="#" class="h-ico h-lang">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="419.7px" height="419.7px" viewBox="267.2 14.2 419.7 419.7" enable-background="new 267.2 14.2 419.7 419.7" xml:space="preserve">
                <path d="M477,433.8c-115.7,0-209.8-94.1-209.8-209.8S361.3,14.2,477,14.2S686.8,108.3,686.8,224
                    S592.7,433.8,477,433.8z M552,290.9c-8.6,37-22.6,72.4-41.5,105.3c57.7-11.3,105.5-50.2,128.3-104.6L552,290.9z M314.8,290.7
                    c22.6,54.8,70.6,94.1,128.6,105.4c-19-33.1-33-68.6-41.6-105.9c-3.8,0-7.6,0-11.3,0C354.4,290.2,329.5,290.4,314.8,290.7z M437.2,290.3c8.7,33.4,22.1,65.3,39.8,94.9c17.7-29.5,31-61.3,39.7-94.6C490.6,290.5,463.4,290.4,437.2,290.3z M557.8,256.6 c22.6,0.1,42.9,0.3,59.6,0.5c13.9,0.1,24.8,0.2,31.7,0.2c4.2-21.6,4.3-43.5,0.3-65.2l-91.3-0.7c1.2,10.8,1.9,21.8,1.9,32.6 C559.8,234.9,559.1,245.8,557.8,256.6z M304.8,191.4c-4.1,21.5-4.2,43.8-0.1,65.3c12.6-0.7,35.6-0.9,78.9-0.9c4,0,8.1,0,12.5,0
                    c-2.5-21.6-2.5-43.5,0-65.1l-4.4,0C337.3,190.7,314.1,191,304.8,191.4z M478.3,256.1l45.1,0.2c1.4-10.7,2.1-21.6,2.1-32.3
                    c0-10.8-0.8-21.8-2.2-32.6c-32.7-0.2-63.7-0.4-92.6-0.4c-2.9,21.6-3,43.5-0.2,65.1H478.3z M552.1,156.8c17.4,0.1,33.7,0.3,48.1,0.4
                    c15.9,0.1,29.2,0.3,39.1,0.3c-22.5-54.9-70.6-94.3-128.6-105.6C529.6,84.7,543.5,119.9,552.1,156.8z M443.4,51.9
                    C385.6,63.2,337.7,102.2,315,156.7c16.1-0.4,42.7-0.5,87-0.5C410.7,119.6,424.6,84.5,443.4,51.9z M478.3,156.5l38.2,0.2
                    c-8.7-33.1-22-64.6-39.5-94c-17.5,29.3-30.7,60.7-39.3,93.6L478.3,156.5z"/>
                </svg>
            </a>
        </div>
        <div class="header-col">
            <a href="#" class="h-ico h-user">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="400px" height="382.5px" viewBox="0 0 400 382.5" enable-background="new 0 0 400 382.5" xml:space="preserve">
                    <path d="M244.1,213.8c31.7-18.7,53.4-56.8,53.4-100.8c0-62.4-43.6-113-97.4-113s-97.4,50.6-97.4,113
                    c0,43.9,21.6,81.9,53,100.6C27.7,226.4,0,297.2,0,382.5h400C400,297.5,366,227,244.1,213.8z"/>
                </svg>
            </a>
        </div>
        <div class="header-col">
            <a href="#" class="h-basket">
                <svg class="ico-basket" viewBox="285.2 46.1 389.5 355.8">
                    <path d="M439.2 328.9c-20.1 0-36.5 16.4-36.5 36.5s16.4 36.5 36.5 36.5 36.5-16.4 36.5-36.5-16.3-36.5-36.5-36.5zm0 50.6c-7.8 0-14.1-6.3-14.1-14.1s6.3-14.1 14.1-14.1 14.1 6.3 14.1 14.1-6.3 14.1-14.1 14.1zm117.4-50.6c-20.1 0-36.5 16.4-36.5 36.5s16.4 36.5 36.5 36.5 36.5-16.4 36.5-36.5-16.4-36.5-36.5-36.5zm0 50.6c-7.8 0-14.1-6.3-14.1-14.1s6.3-14.1 14.1-14.1 14.1 6.3 14.1 14.1-6.4 14.1-14.1 14.1zm116.1-244.8c-2.1-3-5.5-4.7-9.1-4.7H369l-19.8-75.6c-1.3-4.9-5.7-8.4-10.8-8.4h-42c-6.2 0-11.2 5-11.2 11.2 0 6.2 5 11.2 11.2 11.2h33.3l63.6 242.7c1.3 4.9 5.7 8.4 10.8 8.4h203.5c6.2 0 11.2-5 11.2-11.2 0-6.2-5-11.2-11.2-11.2H412.8l-8.1-30.8h219c4.8 0 9-3 10.6-7.5l39.9-114c1.1-3.3.6-7.1-1.5-10.1zM615.8 244H398.9l-24-91.6h272.9l-32 91.6z"/>
                </svg>
                <span>0</span>
            </a>
            <span class="basket-price"></span>
        </div> -->

</header>