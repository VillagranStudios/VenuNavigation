<?php
/**
 * Villagran Studios
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Vtudio
 * @package     Vstudio_Venu
 * @copyright  Copyright (c) 2011-2017 Villagran Studios. and affiliates (http://www.villagranstudios.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Custom Link block
 *
 * @category   Vstudio
 * @package    Vstudio_Venu
 * @author     VillagranStudios Team <support@villagranstudios.com>
 */
class Vstudio_Venu_Block_Adminhtml_MenuManager_Edit_Tab_Custom extends Mage_Adminhtml_Block_Widget_Form {

	protected function _prepareForm() {
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('menu_edit_custom_form', array('legend' => Mage::helper('vstudio_venu')->__('Create Custom Menu')));

		$fieldset->addType('notice', 'Vstudio_Venu_Block_Adminhtml_Form_Field_Renderer_Notice');     
			
		$fieldset->addField('instruction', 'notice', array(
				'name'      => 'instructions',
				'text'     => 'After you click save and continue you will be able to see your custom link on the Menu Information tab'
		));

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
