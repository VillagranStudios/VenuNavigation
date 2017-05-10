<?php
class Vstudio_Venu_Model_Resource_Venu
extends Mage_Core_Model_Resource_Db_Abstract {
	protected function _construct() {
		$this -> _init('vstudio_venu/venu', 'menu_id');
	}
}
