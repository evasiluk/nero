<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Дилеры");
?>
    <div class="usercontent bg--white wrap wrap-content">
        <?
        $manager_groups = CUser::GetUserGroup(CUser::GetID());
        $class = new managersClass();

        $manager_code = $class->get_manager_code($manager_groups);
        $manager_host = $class->get_manager_host($manager_code);
        $dealers_groups = $class->get_dilers_groups($manager_code);
        $dealers = $class->get_active_dealers_list($manager_host);
        ?>
        <br>
        <h1>Перечень активных дилеров</h1>
        <?if($dealers):?>
            <ol>
                <?foreach($dealers as $us):?>
                    <li><a href="/managers/dealer/<?=$us["ID"]?>/"><?=$us["LOGIN"]?></a></li>
                <?endforeach?>
            </ol>
        <?endif?>
    </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>