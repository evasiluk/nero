<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заявки");
?>
<div class="managers-wrap">
    <div class="usercontent bg--white wrap wrap-content">
        <?
        $manager_groups = CUser::GetUserGroup(CUser::GetID());
        $class = new managersClass();

        $manager_code = $class->get_manager_code($manager_groups);
        $manager_host = $class->get_manager_host($manager_code);
        $pretenders = $class->get_pretenders_list($manager_host);
        ?>
        <br>
        <h1>Перечень дилеров на одобрение</h1>
        <?if($pretenders):?>
            <ol>
                <?foreach($pretenders as $us):?>
                    <li><a href="/managers/dealer/<?=$us["ID"]?>/"><?=$us["LOGIN"]?><?if($us["NAME"] || $us["LAST_NAME"]):?> - <?=$us["NAME"]?>&nbsp;<?=$us["LAST_NAME"]?><?endif?></a></li>
                <?endforeach?>
            </ol>
        <?else:?>
            <p>Заявок нет</p>
        <?endif?>
    </div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>