<?php
class managersClass {
   private $dealersByManagers = array(
       "BY" => array(27,28,29,30,31),
       "MSC" => array(15,16,17,18,19),
       "SPB" => array(9,10,11,12,13),
       "UA" => array(21,22,23,24,25),
       "EN" => array(33,34,35,36,37)
   );

   private $managers_groups = array(
       "BY" => 38,
       "MSC" => 39,
       "SPB" => 40,
       "UA" => 41,
       "EN" => 42
   );

   private $managers_by_host = array(
       "BY" => BY_HOST,
       "UA" => UA_HOST,
       "EN" => EN_HOST,
       "MSC" => MSK_HOST,
       "SPB" => SPB_HOST
   );

   public function get_manager_code(array $groups) {
        foreach($this->managers_groups as $code=>$id) {
            if(in_array($id, $groups)) {
                return $code;
            }
        }

        return false;
   }

   public function get_dilers_groups($manager_code) {
        if($this->dealersByManagers[$manager_code]) {
            return $this->dealersByManagers[$manager_code];
        } else return false;
   }

   public function get_manager_host($manager_code) {
       if($this->managers_by_host[$manager_code]) {
           return $this->managers_by_host[$manager_code];
       } else return false;
   }

   public function get_pretenders_list($host) {
       $filter = Array("UF_NERO_SITE" => $host, "ACTIVE" => "N");
       $rsUsers = CUser::GetList(($by = "NAME"), ($order = "desc"), $filter);
       $arSpecUser = array();
       while ($arUser = $rsUsers->Fetch()) {
           $arSpecUser[] = $arUser;
       }

       return $arSpecUser;
   }

   public function get_dealer($uid) {
       $filter = Array("ID" => $uid);
       $rsUsers = CUser::GetList(($by = "NAME"), ($order = "desc"), $filter, array("SELECT"=>array("UF_*")));
       $arSpecUser = array();
       while ($arUser = $rsUsers->Fetch()) {
           $arSpecUser[] = $arUser;
       }

       return $arSpecUser;
   }

   public function get_active_dealers_list($host) {
       $filter = Array("UF_NERO_SITE" => $host, "ACTIVE" => "Y");
       $rsUsers = CUser::GetList(($by = "NAME"), ($order = "desc"), $filter);
       $arSpecUser = array();
       while ($arUser = $rsUsers->Fetch()) {
           $arSpecUser[] = $arUser;
       }

       return $arSpecUser;
   }
}