<?php
class managersClass {
   public $dealersByManagers = array(
       "BY" => array(27,28,29,30,31),
       "MSC" => array(15,16,17,18,19),
       "SPB" => array(9,10,11,12,13),
       "UA" => array(21,22,23,24,25),
       "EN" => array(33,34,35,36,37)
   );

   public $managers_groups = array(
       "BY" => 38,
       "MSC" => 39,
       "SPB" => 40,
       "UA" => 41,
       "EN" => 42
   );

   public $managers_by_host = array(
       BY_HOST => "BY",
       UA_HOST => "UA",
       EN_HOST => "EN",
       MSK_HOST => "MSC",
       SPB_HOST => "SPB"
   );

   public function get_manager_by_host() {}
}