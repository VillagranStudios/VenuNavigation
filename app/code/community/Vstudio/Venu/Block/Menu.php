<?php

class Vstudio_Venu_Block_Menu extends Mage_Core_Block_Template
{

    public static $count = 0;

    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getMenu($name = null)
    {
        $storeId = Mage::app()->getStore()->getId();
        if ($name) {
            $menu = Mage::getModel('vstudio_venu/venu')
                ->getCollection()
                ->addFieldToFilter('menu_title', $name)
                ->addFieldToFilter('menu_status', 1);
            $id = $menu->getColumnValues('menu_id');
            if (empty($id)) {
                return array();
            }

            $collection = Mage::getModel('vstudio_venu/menuitem')
                ->getCollection()
                ->addFieldToFilter('menu_id', $id)
                ->addFieldToFilter('item_status', 1)->setOrder('sort_order', 'ASC');
        } else {
            $menus = Mage::getModel('vstudio_venu/venu')
                ->getCollection()
                ->addFieldToFilter('menu_status', 1);
            $menuItems = array();

            foreach ($menus as $menu) {
                $menuItems[] = Mage::getModel('vstudio_venu/menuitem')
                    ->getCollection()
                    ->addFieldToFilter('menu_id', $menu->getId())
                    ->getData();

            }

        }

        return $collection->getData();
    }

    /**
     *
     * @name name of the menu
     * @return returns an associative array of options
     */
    public function getMenuOptions($name)
    {

        $menu = Mage::getModel('vstudio_venu/venu')
            ->getCollection()
            ->addFieldToFilter('menu_title', $name)
            ->addFieldToFilter('menu_status', 1);
        $options = $menu->getColumnValues('menu_options');

        if (!empty($options)) {
            $options = json_decode(array_shift($options), true);
        }

        return $options;
    }


    public function display_menu($items = array(), $parent = 0, $isChild = false, $options = array('menu_orientation' => 'horz'))
    {
        $html = '';
        if (!empty($items[$parent])) {

            if (!empty($options)){
                extract($options);
            }

            $containerTag = '';
            $containerEndTag = '';
            $menu_orientation = (!empty($menu_orientation)) ? $menu_orientation : '';
            $menuId = (!empty($menu_css_id)) ? "id='{$menu_css_id}'" : '';
            $menuClass = (!empty($menu_css_class)) ? $menu_css_class : '';
            $containerId = (!empty($container_id)) ? "id='{$container_id}'" : '';
            $containerClass = (!empty($container_class)) ? $container_class : '';
            $menu_container = (!empty($menu_container)) ? $menu_container : '';
            $title = (!empty($title)) ? $title : '';

            switch ($menu_container) {
                case 'nav':
                    $containerTag = '<nav ' . $containerId . ' class=" venu-container ' . $containerClass . '">';
                    $containerEndTag = '</nav>';
                    break;
                case 'div':
                    $containerTag = '<div ' . $containerId . ' class=" venu-container ' . $containerClass . '">';
                    $containerEndTag = '</div>';
                    break;
                case 'none':
                    $containerTag = '';
                    $containerEndTag = '';
                    break;

                default:

                    break;
            }

            $i = 0;
            $html .= ($isChild) ? '<ul class="venu-menu-sub">' : '' . $containerTag . '<ul ' . $menuId . 'class="venu-menu '.$title.' venu-menu-' . $menu_orientation . ' ' . $menuClass . '">';
            foreach ($items[$parent] as $item) {
                switch ($i++) {
                    case 0:
                        $class = ' first';
                        break;
                    case (count($items[$parent]) - 1) :
                        $class = ' last';
                        break;
                    default:
                        $class = '';
                        break;
                }
                $html .= "<li class='venu-item {$class}'>";
                $html .= '<a href="' . urldecode($item['item_link']) . '">';
                $html .= $item['item_label'];
                $html .= "</a>";
                $html .= $this->display_menu($items, $item['id'], true, $options);
                $html .= "</li>";
            }
            $html .= ($isChild) ? "</ul>" : "</ul>$containerEndTag";
        }

        return $html;
    }

}
