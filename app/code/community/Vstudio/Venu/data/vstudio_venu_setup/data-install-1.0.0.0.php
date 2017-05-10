<?php
function createVenuSampleData()
{
    $model = Mage::getModel('vstudio_venu/venu');
    $homeUrl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);

    $menu = array(
        'menu_title' => 'Sample Menu',
        'menu_options' => json_encode(array('menu_orientation' => 'horz', 'menu_container' => 'nav', 'title' => 'sample_menu')),
        'menu_status' => 1,
        'menu_code' => '{{block type="vstudio_venu/menu" block_id="sample_menu" template="vstudio/venu/menu.phtml" menu_title="Sample Menu"}}',
    );

    $customItems = array(
        array(
            'title' => 'Home',
            'link' => $homeUrl,
            'position' => 0,
        ),
        array(
            'title' => 'Advance Search',
            'link' => $homeUrl . 'index.php/catalogsearch/advanced/',
            'position' => 1,
        ),
        array(
            'title' => 'Orders and Returns',
            'link' => $homeUrl . 'index.php/sales/guest/form/',
            'position' => 2,
        ),
        array(
            'title' => 'Search Terms',
            'link' => $homeUrl . 'index.php/catalogsearch/term/popular/',
            'position' => 3,
        ),
        array(
            'title' => 'Sitemap',
            'link' => $homeUrl . 'index.php/catalog/seo_sitemap/category/',
            'position' => 4,
        ),
        array(
            'title' => 'Contact Us',
            'link' => $homeUrl . 'index.php/contacts/',
            'position' => 5,
        ),

    );

    $menuId = $model->setData($menu)->save();

    if (!empty($customItems)) {
        foreach ($customItems as $item) {
            $menuItem = Mage::getModel('vstudio_venu/menuitem');
            $menuItem->setItemLabel($item['title']);
            $menuItem->setItemLink(urlencode($item['link']));
            $menuItem->setSortOrder(urlencode($item['position']));
            $menuItem->setMenuId($menuId->getId());
            try {
                $menuItem->save();
            } catch (Exception $e) {
                Mage::log("Problem saving custom menu item " . $e->getMessage());
            }
        }
    }
}

createVenuSampleData();