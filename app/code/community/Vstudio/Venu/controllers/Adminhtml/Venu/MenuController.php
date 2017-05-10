<?php

class Vstudio_Venu_Adminhtml_Venu_MenuController
    extends Mage_Adminhtml_Controller_Action
{

    protected function _initAction()
    {
        $this->loadLayout()->_setActiveMenu('vstudio_venu_menu')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Menu Manager'), Mage::helper('adminhtml')->__('Menu Manager'));
        return $this;
    }

    public function indexAction()
    {
        $this->_initAction()->renderLayout();
        return $this;
    }

    public function ajaxAction() 
    {
        $id = $this->getRequest()->getPost('deleteItem');
        $result = '';
        if ( $id ) {

            try {
                 $menuItem = Mage::getModel('vstudio_venu/menuitem')->setId($id);
                 $menuItem->delete();
                 $result = "menu item with id : $id. Has been deleted";
            } catch(Exception $e) {
                $result = "Something went wront: " .$e->getMessage();
            }
        }
        
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
        
    }

    public function editAction()
    {
        // lets get the id of the menu
        $id = $this->getRequest()->getParam('id');
        // lets load our menu from the database
        $model = Mage::getModel('vstudio_venu/venu')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            $menuItems = Mage::getModel('vstudio_venu/menuitem')->getCollection()->addFieldToFilter('menu_id', $model->getId());
            $items = array();

            if (!empty($menuItems)) {
                foreach ($menuItems as $item) {
                    $items[] = $item->getData();
                }
            }

            $model->setData('menu_items', $items);
            Mage::register('venu_data', $model);

            $this->loadLayout();
            // set our menu from adminhtml.xml
            $this->_setActiveMenu('vstudio_venu_menu');

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Menu Manager'), Mage::helper('adminhtml')->__('Menu Manager'));

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Menu News'), Mage::helper('adminhtml')->__('Menu News'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $block = $this->getLayout()->getBlock('catalog.wysiwyg.js');
            if ($block) {
                $block->setStoreId($product->getStoreId());
            }

            $this->_addLeft($this->getLayout()->createBlock('vstudio_venu/adminhtml_menumanager_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vstudio_venu')->__('Menu does not exist'));
            $this->_redirect('*/*/');
        }

    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('vstudio_venu/venu');

            $menuId = $this->getRequest()->getParam('id');

            if (isset($data['menu_title']) && !empty($data['menu_title'])) {
                $title = $data['menu_title'];
                $code = strtolower(implode('_', explode(' ', $title)));
                $data['menu_options']["title"] = $code;
                $blockCod = '{{block type="vstudio_venu/menu" block_id="' . $code . '" template="vstudio/venu/menu.phtml" menu_title="' . $title . '"}}';
                $data['menu_code'] = $blockCod;
            }
            if (isset($data['menu_options']) && !empty($data['menu_options'])) {
                $data['menu_options'] = json_encode($data['menu_options']);
            }
            $model->setData($data)->setId($menuId);
            try {
                $model->save();
                // create menu item
                $this->createMenuItem($model->getId());

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('vstudio_venu')->__('Menu was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }

                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vstudio_venu')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }

    protected function createMenuItem($menu_id)
    {

        if ($selectedPages = $this->getRequest()->getPost('pages')) {
            $_cmsPages = Mage::getSingleton('cms/page')
                ->getCollection()
                ->addFieldToFilter('is_active', 1)
                ->addFieldToFilter('page_id', array('in' => $selectedPages));

            if (!empty($_cmsPages)) {
                foreach ($_cmsPages as $page) {
                    $url = Mage::helper('cms/page')->getPageUrl($page->getId());
                    $menuItem = Mage::getModel('vstudio_venu/menuitem');
                    $menuItem->setItemLabel($page->getTitle());
                    $menuItem->setItemLink(urlencode($url));
                    $menuItem->setMenuId($menu_id);
                    try {
                        $menuItem->save();
                    } catch (Exception $e) {
                        Mage::log("Problem saving page menu item " . $e->getMessage());
                    }

                }
            }

        }

        if ($customItems = $this->getRequest()->getPost('custom')) {

            if (!empty($customItems)) {
                foreach ($customItems as $item) {
                    if (empty($item['title']) || empty($item['link']))
                        continue;

                    $menuItem = Mage::getModel('vstudio_venu/menuitem');
                    $menuItem->setItemLabel($item['title']);
                    $menuItem->setItemLink(urlencode($item['link']));
                    $menuItem->setMenuId($menu_id);
                    try {
                        $menuItem->save();
                    } catch (Exception $e) {
                        Mage::log("Problem saving custom menu item " . $e->getMessage());
                    }
                }
            }
        }

        if ($items = $this->getRequest()->getPost('item')) {
            if (!empty($items)) {
                foreach ($items as $item) {
                    $item['item_link'] = urlencode($item['item_link']);
                    $menuItem = Mage::getModel('vstudio_venu/menuitem')->setData($item)->setId($item['id']);

                    if (isset($item['delete'])) {
                        $menuItem->delete();
                    } else {
                        try {
                            $menuItem->save();
                        } catch (Exception $e) {
                            Mage::log("error saving menu item " . $e->getMessage());
                        }
                    }

                }
            }
        }

        if ($categoryIds = $this->getRequest()->getPost('categories')) {
            if (!empty($categoryIds)) {
                $categoryIds = explode(',', $categoryIds);
                if (is_array($categoryIds)) {
                    $categoryIds = array_unique($categoryIds);
                } else {
                    throw new Exception("Error trying to save category item : categories must be an array", 1);
                }
                foreach ($categoryIds as $id) {
                    if (empty($id))
                        continue;
                    $_category = Mage::getModel('catalog/category')->load($id);
                    $menuItem = Mage::getModel('vstudio_venu/menuitem');
                    $menuItem->setItemLabel($_category->getName());
                    $menuItem->setItemLink(urlencode($_category->getUrl()));
                    $menuItem->setMenuId($menu_id);
                    try {
                        $menuItem->save();
                    } catch (Exception $ex) {
                        Mage::log("error saving category menu item " . $ex->getMessage());
                    }
                }
            }
        }

        return;
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function massDeleteAction()
    {
        $menuIds = $this->getRequest()->getParam('menu_delete');
        if (!is_array($menuIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vstudio_venu')->__('Please select one or more menus.'));
        } else {
            try {

                $menu = Mage::getModel('vstudio_venu/venu');

                foreach ($menuIds as $menuId) {
                    $menu->load($menuId)->delete();
                    // get tables associated with this menu
                    $menuItems = Mage::getModel('vstudio_venu/menuitem')->getCollection()->addFilter('menu_id', $menuId);

                    if (!empty($menuItems)) {
                        foreach ($menuItems as $item) {
                            $item->delete();
                        }
                    }
                }

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($menuIds)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function deleteAction()
    {
        if ($menuId = $this->getRequest()->getParam('id')) {
            try {
                $menu = Mage::getModel('vstudio_venu/venu');
                $menu->load($menuId)->delete();
                // get tables associated with this menu
                $menuItems = Mage::getModel('vstudio_venu/menuitem')->getCollection()->addFilter('menu_id', $menuId);

                if (!empty($menuItems)) {
                    foreach ($menuItems as $item) {
                        $item->delete();
                    }
                }

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Menu was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    protected function _initMenu()
    {
        $menuId = (int)$this->getRequest()->getParam('id');
        $menu = Mage::getModel('vstudio_venu/venu');

        if ($menuId) {
            $menu->load($menuId);
        }
        Mage::register('venu_data', $menu);
        Mage::register('current_menu', $menu);
        return $menu;
    }

    public function categoriesAction()
    {
        $this->_initMenu();
        $this->loadLayout();
        $this->renderLayout();
    }

    public function categoriesJsonAction()
    {
        $this->_initMenu();
        $this->getResponse()->setBody($this->getLayout()->createBlock('vstudio_venu/adminhtml_menumanager_edit_tab_categories')->getCategoryChildrenJson($this->getRequest()->getParam('category')));
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('admin/vstudio_venu_menu');
    }

}
