<?php

class Vstudio_Venu_Model_Options
extends  Mage_Core_Model_Abstract {

	const STATUS_ENABLED = 1;
	const STATUS_DISABLED = 0;
	const HORZ_ORIENTATION = 'horz';
	const VERT_ORIENTATION = 'vert';

	public function getOptionStatus() {
		return array(
			self::STATUS_ENABLED => Mage::helper('vstudio_venu') -> __('Active'),
			self::STATUS_DISABLED => Mage::helper('vstudio_venu') -> __('Non Active')
		);
	}

	public function getOptionOrientation() {
		return array(
			self::HORZ_ORIENTATION => Mage::helper('vstudio_venu') -> __('Horizontal'),
			self::VERT_ORIENTATION => Mage::helper('vstudio_venu') -> __('Vertical')
		);
	}

	public function getOptionPages() {
		$_collection = Mage::getSingleton('cms/page') -> getCollection() -> addFieldToFilter('is_active', 1);

		$_result = array( array(
				'value' => -1,
				'label' => 'None'
			));

		foreach ($_collection as $item) {
			$data = array(
				'value' => $item -> getData('page_id'),
				'label' => $item -> getData('title')
			);

			$_result[] = $data;
		}
		return $_result;
	}

}
