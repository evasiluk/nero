<?php
class neroCatalogClass {
    public $dealers_groups = array(9,10,11,12,13,15,16,17,18,19,21,22,23,24,25,27,28,29,30,31,33,34,35,36,37);

    public function is_dealer($ugroups) {
        foreach($ugroups as $gid) {
            if(in_array($gid, $this->dealers_groups)) {
                return true;
            }
        }
        return false;
    }


}