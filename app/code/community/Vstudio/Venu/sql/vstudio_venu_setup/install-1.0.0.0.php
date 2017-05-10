<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$menuTable = $installer->getConnection()
    ->newTable($installer->getTable('vstudio_venu/venu'))
    ->addColumn('menu_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,), 'Menu Id')
    ->addColumn('menu_title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 30,
        array(
            'nullable' => false,
        ), 'Menu Title')
    ->addColumn('menu_position', Varien_Db_Ddl_Table::TYPE_TINYINT, 4,
        array(
            'nullable' => false,
        ), 'menu_position')
    ->addColumn('menu_status', Varien_Db_Ddl_Table::TYPE_SMALLINT, 6,
        array(
            'nullable' => false,
            'default' => 1,
        ), 'Menu Status')
    ->setComment('Vstudio_Venu Menu Entity')
    ->addColumn('menu_code', Varien_Db_Ddl_Table::TYPE_LONGVARCHAR, 500,
        array(
            'nullable' => false,
        ), 'Menu Code')
    ->addColumn('menu_options', Varien_Db_Ddl_Table::TYPE_LONGVARCHAR, 500,
        array(
            'nullable' => false,
        ), 'Menu Options');


$itemTable = $installer->getConnection()
    ->newTable($installer->getTable('vstudio_venu/menuitem'))/* name on the config.xml entity tag*/
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_SMALLINT, 8,
        array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,), 'Id')
    ->addColumn('item_label', Varien_Db_Ddl_Table::TYPE_VARCHAR, 30,
        array(
            'nullable' => false,
        ), 'Item Label')
    ->addColumn('item_link', Varien_Db_Ddl_Table::TYPE_VARCHAR, 500,
        array(
            'nullable' => false,
        ), 'Item Link')
    ->addColumn('item_attributes', Varien_Db_Ddl_Table::TYPE_LONGVARCHAR, 25000,
        array(
            'nullable' => false,), 'Attributes')
    ->addColumn('parent_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11,
        array(
            'unsigned' => true,
            'nullable' => false,
            'default' => 0,
        ), 'Parent')
    ->addColumn('sort_order', Varien_Db_Ddl_Table::TYPE_INTEGER, 11,
        array(
            'unsigned' => true,
            'nullable' => false,
            'default' => 0,
        ), 'Sort Order')
    ->addColumn('item_status', Varien_Db_Ddl_Table::TYPE_TINYINT, 3,
        array(
            'unsigned' => true,
            'nullable' => false,
            'default' => 1,
        ), 'Item Status')
    ->addColumn('menu_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, 6,
        array(
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,), 'Menu Id');

$installer->getConnection()->createTable($menuTable);
$installer->getConnection()->createTable($itemTable);
$installer->endSetup();
