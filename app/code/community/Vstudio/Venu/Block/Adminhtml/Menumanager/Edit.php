<?php

/**
 *
 * When clicked on an items grid
 * this is the container for that item
 */
class Vstudio_Venu_Block_Adminhtml_MenuManager_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'menu_id';
        $this->_blockGroup = 'vstudio_venu';
        $this->_controller = 'adminhtml_menumanager';

        $this->_updateButton('save', 'label', Mage::helper('vstudio_venu')->__('Save Menu'));
        $this->_updateButton('delete', 'label', Mage::helper('vstudio_venu')->__('Delete Menu'));

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

	protected function _prepareLayout() {
	    parent::_prepareLayout();
	    if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
	        $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
	    }
	}

    public function getHeaderText()
    {
    	if( Mage::registry('venu_data') && Mage::registry('venu_data')->getId() ) {
            return Mage::helper('vstudio_venu')->__("Edit Menu '%s'", $this->htmlEscape(Mage::registry('venu_data')->getData('menu_title')));
        } else {
            return Mage::helper('vstudio_venu')->__('Add New Menu');
        }
    }
}