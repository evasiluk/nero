<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Дилеры");
?>
<div class="managers-wrap">
    <div class="usercontent bg--white wrap wrap-content">
        <?
        $manager_groups = CUser::GetUserGroup(CUser::GetID());
        $class = new managersClass();

        $manager_code = $class->get_manager_code($manager_groups);
        $dealers_groups = $class->get_dilers_groups($manager_code);
        $dealers = $class->get_active_dealers_list($dealers_groups);
        ?>
        <br>
        <h1>Перечень активных дилеров</h1>
        <?if($dealers):?>
            <ol>
                <?foreach($dealers as $us):?>
                    <li><a href="/managers/dealer/<?=$us["ID"]?>/"><?=$us["LOGIN"]?><?if($us["NAME"] || $us["LAST_NAME"]):?> - <?=$us["NAME"]?>&nbsp;<?=$us["LAST_NAME"]?><?endif?></a></li>
                <?endforeach?>
            </ol>
        <?else:?>
            <p>Активных дилеров нет</p>
        <?endif?>
    </div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>