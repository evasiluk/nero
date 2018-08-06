<?php
namespace Astronim;

/**
 * @var $USER \CUser
 * @var $APPLICATION \CMain
 */

defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();
use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Text\String;

$app = Application::getInstance();
$context = $app->getContext();
$request = $context->getRequest();

Loc::loadMessages($context->getServer()->getDocumentRoot() . "/bitrix/modules/main/options.php");
Loc::loadMessages(__FILE__);

$options = include __DIR__ . "/options_inc.php";

$tabs = [];
foreach ($options as $key => $tab) {
    $tabs[] = [
        "DIV" => $key,
        "TAB" => Loc::getMessage("tab_$key"),
        "TITLE" => Loc::getMessage("title_$key"),
    ];
}

$tabControl = new \CAdminTabControl("tabControl", $tabs);

if ((!empty($save) || !empty($restore)) && $request->isPost() && check_bitrix_sessid()) {
    $success = true;

    if (!empty($restore)) {
        Option::delete(ADMIN_MODULE_NAME);
        \CAdminMessage::showMessage(array(
            "MESSAGE" => Loc::getMessage("REFERENCES_OPTIONS_RESTORED"),
            "TYPE" => "OK",
        ));
    } elseif (!empty($save)) {
        foreach ($options as $key => $tab) {
            foreach ($tab as $option_name => $props) {
                $value = ($request->getPost($option_name));

                if ($props['multiple']){
                    $value = array_filter($value, function($value) { return $value !== ''; });
                    $value = json_encode($value);
                }

                Option::set(
                    ADMIN_MODULE_NAME,
                    $option_name,
                    $value
                );
            }
        }
    }

    if ($success) {
        \CAdminMessage::showMessage(array(
            "MESSAGE" => Loc::getMessage("REFERENCES_OPTIONS_SAVED"),
            "TYPE" => "OK",
        ));
    } else {
        \CAdminMessage::showMessage(Loc::getMessage("REFERENCES_INVALID_VALUE"));
    }
}

$tabControl->begin();
?>


<form method="post"
      action="<?= sprintf('%s?mid=%s&lang=%s', $request->getRequestedPage(), urlencode($request->get('mid')), LANGUAGE_ID) ?>"
      id="astronim.base">
    <?php
    echo bitrix_sessid_post();

    foreach ($options as $key => $tab):
        $tabControl->beginNextTab();

        foreach ($tab as $option_name => $prop):
            $title = $prop['title'] ?: Loc::getMessage('field_' . $option_name);
            switch ($prop['type']) {
                case 'select':
                    if ($prop['multiple'])
                        $selected_values = json_decode(Option::get(ADMIN_MODULE_NAME, $option_name, json_encode($prop['default'])), true);
                    else
                        $selected_values = [Option::get(ADMIN_MODULE_NAME, $option_name, $prop['default'])]; ?>
                    <tr>
                        <td width="40%">
                            <label for="<?= $option_name ?>"><?= $title ?>:</label>
                        <td width="60%">
                            <select name="<?= $option_name ?><?= ($prop['multiple'] ? '[]' : '') ?>"
                                    id="<?= $option_name ?>" <?= ($prop['multiple'] ? 'multiple' : '') ?>>
                                <? foreach ($prop['values'] as $key => $value):
                                    $selected = in_array($key, $selected_values); ?>
                                    <option <?= ($selected ? 'selected' : ''); ?>
                                            value="<?= $key ?>"><?= $value ?></option>
                                <? endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <? break;

                case 'title':
                    ?>
                    <tr>
                        <td width="100%" colspan="2" align="center">
                            <h3>
                                <?= $title . ($prop['value'] ? ': ' . $prop['value'] : ''); ?>
                            </h3>
                        </td>
                    </tr>
                    <? break;

                case 'static':
                    ?>
                    <tr>
                        <td width="40%">
                            <label for="<?= $option_name ?>"><?= $title ?>:</label>
                        <td width="60%">
                            <b><?= $prop['value'] ?></b>
                        </td>
                    </tr>
                    <? break;

                case 'textarea':
                    ?>
                    <tr>
                        <td width="40%">
                            <label for="<?= $option_name ?>"><?= $title ?>:</label>
                        <td width="60%">
                            <textarea
                                    name="<?= $option_name ?>"
                                    id="<?= $option_name ?>"
                            ><?= String::htmlEncode(Option::get(ADMIN_MODULE_NAME, $option_name, $prop['default'])); ?></textarea>
                        </td>
                    </tr>
                    <? break;

                case 'date':
                    ?>
                    <? if (!$prop['multiple']) { ?>
                    <tr>
                        <td width="40%">
                            <label for="<?= $option_name ?>"><?= $title ?>:</label>
                        <td width="60%">
                            <input type="text"
                                   size="50"
                                   name="<?= $option_name ?>"
                                   id="<?= $option_name ?>"
                                   value="<?= String::htmlEncode(Option::get(ADMIN_MODULE_NAME, $option_name, $prop['default'])); ?>"
                            />
                        </td>
                    </tr>
                <? } else { ?>
                    <? foreach (json_decode(Option::get(ADMIN_MODULE_NAME, $option_name, ''), true) as $key => $value):
                        if (null === $value) continue;
                        $i++; ?>
                        <tr>
                            <td width="40%">
                                <label for="<?= $option_name ?>"><?
                                    if (1 == $i)
                                        echo $title;
                                    echo "[$i]";
                                    ?></label>
                            <td width="60%">
                                <input type="text"
                                       size="50"
                                       onclick="BX.calendar({
                                       node:this,
                                       field:this,
                                       form: 'voip',
                                       bTime: false
                                       })"
                                       class="bx-calendar-icon" style="top: 25px;"
                                       name="<?=$option_name?>[<?=$key?>]"
                                       id="<?=$option_name?>"
                                       value="<?=String::htmlEncode($value);?>"
                                />
                            </td>
                        </tr>
                    <? endforeach; ?>
                    <tr>
                        <td width="40%">
                            <label for="<?= $option_name ?>"><?= $title ?>:</label>
                        <td width="60%">
                            <input type="text"
                                   size="50"
                                   name="<?=$option_name?>[]"
                                   id="<?=$option_name?>"
                                   onclick="BX.calendar({
                                       node:this,
                                       field:this,
                                       form: 'voip',
                                       bTime: false
                                       })"
                                   class="bx-calendar-icon" style="top: 25px;"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="adm-detail-content-cell-l"></td>
                        <td style="padding-bottom:10px;" class="adm-detail-content-cell-r">
                            <a href="javascript:void(0)" onclick="addInput(this)" class="adm-btn">+</a>
                        </td>
                    </tr>
                <? } ?>

                    <? break;
                case 'text':
                default:
                    ?>
                    <? if (!$prop['multiple']): ?>
                    <tr>
                        <td width="40%">
                            <label for="<?= $option_name ?>"><?= $title ?>:</label>
                        <td width="60%">
                            <input type="text"
                                   size="50"
                                   name="<?= $option_name ?>"
                                   id="<?= $option_name ?>"
                                   value="<?= String::htmlEncode(Option::get(ADMIN_MODULE_NAME, $option_name, $prop['default'])); ?>"
                            />
                        </td>
                    </tr>
                <? else: ?>
                    <? foreach (json_decode(Option::get(ADMIN_MODULE_NAME, $option_name, ''), true) as $key => $value):
                        if (null === $value) continue;
                        $i++; ?>
                        <tr>
                            <td width="40%">
                                <label for="<?= $option_name ?>"><?
                                    if (1 == $i)
                                        echo $title;
                                    echo "[$i]";
                                    ?></label>
                            <td width="60%">
                                <input type="text"
                                       size="50"
                                       name="<?= $option_name ?>[<?= $key ?>]"
                                       id="<?= $option_name ?>"
                                       value="<?= String::htmlEncode($value); ?>"
                                />
                            </td>
                        </tr>
                    <? endforeach; ?>
                    <tr>
                        <td width="40%">
                            <label for="<?= $option_name ?>"><?= $title ?>:</label>
                        <td width="60%">
                            <input type="text"
                                   size="50"
                                   name="<?= $option_name ?>[]"
                                   id="<?= $option_name ?>"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="adm-detail-content-cell-l"></td>
                        <td style="padding-bottom:10px;" class="adm-detail-content-cell-r">
                            <a href="javascript:void(0)" onclick="addInput(this)" class="adm-btn">+</a>
                        </td>
                    </tr>
                <? endif; ?>
                    <? break; ?>
                <? } ?>
        <?endforeach;
    endforeach;

    $tabControl->buttons(); ?>
    <input type="submit"
           name="save"
           value="<?= Loc::getMessage("MAIN_SAVE") ?>"
           title="<?= Loc::getMessage("MAIN_OPT_SAVE_TITLE") ?>"
           class="adm-btn-save"
    />
    <input type="submit"
           name="restore"
           title="<?= Loc::getMessage("MAIN_HINT_RESTORE_DEFAULTS") ?>"
           onclick="return confirm('<?= addslashes(GetMessage("MAIN_HINT_RESTORE_DEFAULTS_WARNING")) ?>')"
           value="<?= Loc::getMessage("MAIN_RESTORE_DEFAULTS") ?>"
    />
    <? $tabControl->end(); ?>
</form>


<script type="text/javascript">
    function addInput(a) {
        var row = BX.findParent(a, {'tag': 'tr'});
        var tbl = row.parentNode;

        var tableRow = tbl.rows[row.rowIndex - 1].cloneNode(true);

        if(BX.findChildren(tableRow, {'tag': 'label'}, true)[0])
            BX.findChildren(tableRow, {'tag': 'label'}, true)[0].innerHTML = "";
        if(BX.findChildren(tableRow, {'tag': 'textarea'}, true)[0])
            BX.findChildren(tableRow, {'tag': 'textarea'}, true)[0].innerHTML = "";
        if(BX.findChildren(tableRow, {'tag': 'input'}, true)[0])
            BX.findChildren(tableRow, {'tag': 'input'}, true)[0].value = "";
        tbl.insertBefore(tableRow, row);
    }
</script>