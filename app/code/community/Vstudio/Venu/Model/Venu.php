<?php
class Vstudio_Venu_Model_Venu extends Mage_Core_Model_Abstract {
	protected $_eventPrefix = 'vstudio_venu_menu';
	protected $_eventObject = 'venu';
	protected $_categoryInstance = null;

	protected function _construct() {
		$this -> _init('vstudio_venu/venu');
	}

	/**
	 * Retrieve assigned category Ids
	 *
	 * @return array
	 */
	public function getCategoryIds() {

		return array();
	}

}
