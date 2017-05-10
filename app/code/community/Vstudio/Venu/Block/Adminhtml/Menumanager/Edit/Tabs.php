<?php
class Vstudio_Venu_Block_Adminhtml_MenuManager_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('venu_manage_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('vstudio_venu')->__('Menu Information'));
    }

    protected function _beforeToHtml() {
        $this->addTab('form_section', array(
            'label' => Mage::helper('vstudio_venu')->__('Menu Information'),
            'title' => Mage::helper('vstudio_venu')->__('Menu Information'),
            'content' => $this->getLayout()->createBlock('vstudio_venu/adminhtml_menumanager_edit_tab_form')->toHtml(),

        ));
        $this->addTab('form_custom', array(
            'label' => Mage::helper('vstudio_venu')->__('Add Custom Menu Link'),
            'title' => Mage::helper('vstudio_venu')->__('Add Custom Menu Link'),
            'content' => $this->getLayout()->createBlock('vstudio_venu/adminhtml_menumanager_edit_tab_custom')->toHtml(),

        ));
        $this->addTab('form_pages', array(
            'label' => Mage::helper('vstudio_venu')->__('Add Page Menu Link'),
            'title' => Mage::helper('vstudio_venu')->__('Add Page Menu Link'),
            'content' => $this->getLayout()->createBlock('vstudio_venu/adminhtml_menumanager_edit_tab_pages')->toHtml(),

        ));
      $this->addTab('categories', array(
          'label'     => Mage::helper('catalog')->__('Add Category Menu Link'),
          'url'       => $this->getUrl('*/*/categories', array('_current' => true)),
          'class'     => 'ajax',
      ));
        return parent::_beforeToHtml();
    }
}