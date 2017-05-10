<?php

class Vstudio_Venu_Block_Adminhtml_MenuManager_Edit_Tab_Custom extends Mage_Adminhtml_Block_Widget_Form {

	protected function _prepareForm() {
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('menu_edit_custom_form', array('legend' => Mage::helper('vstudio_venu')->__('Create Custom Menu')));

		$fieldset->addField('custom_title', 'text', array(
			'label' => Mage::helper('vstudio_venu')->__('Link Title'),
			'name' => 'custom[0][title]',
		));
		$fieldset->addField('custom_link', 'text', array(
			'label' => Mage::helper('vstudio_venu')->__('Link Url'),
			'name' => 'custom[0][link]',
		));
		/** set form data **/
		if (Mage::getSingleton('adminhtml/session') -> getVenuData()) {
			$form -> setValues(Mage::getSingleton('adminhtml/session') -> getVenuData());
			Mage::getSingleton('adminhtml/session') -> setVenuData(null);
		} elseif (Mage::registry('venu_data')) {
			$menuItems = Mage::registry('venu_data') -> getData('menu_items');
			$form -> setValues(Mage::registry('venu_data') -> getData());
		}

		return parent::_prepareForm();
	}

}
