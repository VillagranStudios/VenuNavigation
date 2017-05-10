<?php

/**
 * @author    contact@leandrovillagran.com
 */
class Vstudio_Venu_Block_Adminhtml_MenuManager_Edit_Tab_Pages extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('banner_form', array('legend' => Mage::helper('vstudio_venu')->__('Menu Pages')));
        $fieldset->addField('pages', 'multiselect', array(
            'label' => Mage::helper('vstudio_venu')->__('Visible In'),
            'name' => 'pages[]',
            'values' => Mage::getSingleton('vstudio_venu/options')->getOptionPages(),
        ));

        if (Mage::getSingleton('adminhtml/session')->getVliderData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getVliderData());
            Mage::getSingleton('adminhtml/session')->setVliderData(null);
        } elseif (Mage::registry('venu_data')) {
            $form->setValues(Mage::registry('venu_data')->getData());
        }

        return parent::_prepareForm();
    }

}
