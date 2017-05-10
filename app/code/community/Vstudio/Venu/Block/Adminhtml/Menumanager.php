<?php

class Vstudio_Venu_Block_Adminhtml_MenuManager
extends Mage_Adminhtml_Block_Widget_Grid_Container {
	public function __construct() {
		// $this->_blockGroup.'/' . $this->_controller . '_grid'
		$this -> _controller = 'adminhtml_menumanager';
		$this -> _blockGroup = 'vstudio_venu';
		$this -> _headerText = Mage::helper('vstudio_venu') -> __('Menu Manager');
		$this -> _addButtonLabel = Mage::helper('vstudio_venu') -> __('Add Menu');
		parent::__construct();
	}

}
