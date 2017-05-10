<?php

class Vstudio_Venu_Block_Adminhtml_MenuManager_Edit_Tab_Categories
extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Categories {
	protected $_categoryIds = null;
    protected $_selectedNodes = null;

    /**
     * Specify template to use
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('vstudio/venu/edit/tab/category.phtml');
		$this->_withProductCount = false;
    }


    /**
     * Return array with category IDs which the product is assigned to
     *
     * @return array
     */
    protected function getCategoryIds()
    {
        return $this->getMenu()->getCategoryIds();
    }
    /**
     * Checks when this block is readonly
     *
     * @return boolean
     */
    public function isReadonly()
    {
        return $this->getMenu()->getCategoriesReadonly();
    }

    /**
     * Retrieve currently edited product
     *
     * @return Vstudio_Venu_Model_Venu
     */
    public function getMenu()
    {
        return Mage::registry('current_menu');
    }

    /**
     * Returns array with configuration of current node
     *
     * @param Varien_Data_Tree_Node $node
     * @param int                   $level How deep is the node in the tree
     * @return array
     */
    protected function _getNodeJson($node, $level = 1)
    {

        $item = parent::_getNodeJson($node, $level);

        if ($this->_isParentSelectedCategory($node)) {
            $item['expanded'] = true;
        }

        if (in_array($node->getId(), $this->getCategoryIds())) {

            $item['checked'] = true;
        }

        if ($this->isReadonly()) {
            $item['disabled'] = true;
        }

        return $item;
    }
    /**
     * Returns URL for loading tree
     *
     * @param null $expanded
     * @return string
     */
    public function getLoadTreeUrl($expanded = null)
    {
        return $this->getUrl('*/*/categoriesJson', array('_current' => true));
    }
}
