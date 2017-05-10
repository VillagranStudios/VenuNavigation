<?php
class Vstudio_Venu_Model_Menuitem extends Mage_Core_Model_Abstract {
	protected $_eventPrefix = 'vstudio_venu_menuitem';
	protected $_eventObject = 'venu';
	protected $_categoryInstance = null;

	protected function _construct() {
		$this -> _init('vstudio_venu/menuitem');
	}


}
