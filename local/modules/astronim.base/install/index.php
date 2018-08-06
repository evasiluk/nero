<?
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
class astronim_base extends CModule
{
    public $MODULE_ID = "astronim.base";
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $PARTNER_NAME;
    public $PARTNER_URI;

    function __construct()
    {
        $arModuleVersion = [];

        include(__DIR__ . "/version.php");

        if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
        {
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        }

        $this->MODULE_NAME = Loc::getMessage('MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('MODULE_DESCRIPTION');
        $this->PARTNER_NAME = Loc::getMessage('PARTNER_NAME');
        $this->PARTNER_URI = Loc::getMessage('PARTNER_URI');
    }

    public function DoInstall()
    {
        RegisterModule($this->MODULE_ID);
        echo CAdminMessage::ShowNote(Loc::getMessage('INSTALL_COMPLETE_TITLE'));
    }

    public function DoUninstall()
    {
        UnRegisterModule($this->MODULE_ID);
        echo CAdminMessage::ShowNote(Loc::getMessage('INSTALL_COMPLETE_TITLE'));
    }
}
?>