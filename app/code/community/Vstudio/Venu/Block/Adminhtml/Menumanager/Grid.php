<?php
/**
 * Leandro Villagran
 * @category   Vstudio
 * @package    Vstudio_Venu
 * @copyright  Copyright (c) 2010-2011 Leandro Villagran. (http://www.leandrovillagran.com)
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
class Vstudio_Venu_Block_Adminhtml_MenuManager_Grid extends Mage_Adminhtml_Block_Widget_Grid {

	public function __construct() {
		parent::__construct();
		$this -> setId('manageMenuGrid');
		$this -> setUseAjax(true);
		$this -> setDefaultSort('menu_id');
		$this -> setDefaultDir('ASC');
		$this -> setSaveParametersInSession(true);
	}

	protected function _prepareCollection() {
		// lets get all our menus
		$collection = Mage::getModel('vstudio_venu/venu') -> getCollection();
		// lets set the collection for a our grid
		$this -> setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _prepareColumns() {
		$options = Mage::getSingleton('vstudio_venu/options');

		$this -> addColumn('menu_id', array(
			'header' => Mage::helper('vstudio_venu') -> __('ID'),
			'align' => 'right',
			'width' => '50px',
			'index' => 'menu_id',
		));

		$this -> addColumn('menu_title', array(
			'header' => Mage::helper('vstudio_venu') -> __('Title'),
			'align' => 'left',
			'index' => 'menu_title',
		));

		$this -> addColumn('menu_status', array(
			'header' => Mage::helper('vstudio_venu') -> __('Status'),
			'align' => 'left',
			'width' => '80px',
			'index' => 'menu_status',
			'type' => 'options',
			'options' => $options -> getOptionStatus(),
		));

		$this -> addColumn('action', array(
			'header' => Mage::helper('vstudio_venu') -> __('Action'),
			'width' => '100',
			'type' => 'action',
			'getter' => 'getId',
			'actions' => array( array(
					'caption' => Mage::helper('vstudio_venu') -> __('Edit'),
					'url' => array('base' => '*/*/edit'),
					'field' => 'id'
				)),
			'filter' => false,
			'sortable' => false,
			'index' => 'stores',
			'is_system' => true,
		));
		return parent::_prepareColumns();
	}

	protected function _prepareMassaction() {
		$this -> setMassactionIdField('menu_id');
		$this -> getMassactionBlock() -> setFormFieldName('menu_delete');
		$this -> getMassactionBlock() -> addItem('delete', array(
			'label' => Mage::helper('vstudio_venu') -> __('Delete'),
			'url' => $this -> getUrl('*/*/massDelete'),
			'confirm' => Mage::helper('vstudio_venu') -> __('Are you sure?')
		));
		return $this;
	}

	public function getRowUrl($row) {
		// This is where our row data will link to
		return $this -> getUrl('*/*/edit', array('id' => $row -> getId()));
	}

}
