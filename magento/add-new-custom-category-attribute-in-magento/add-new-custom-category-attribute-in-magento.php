<?php 
/*
 * Add custom category attribute for General tab
 * Image Attribute
 */
$installer = new Mage_Sales_Model_Mysql4_Setup;
$attribute  = array(
    'group' => 'General',
    'type' => 'varchar',
    'label' => 'Story Image',
    'input' => 'image',
    'backend' => 'catalog/category_attribute_backend_image',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'default' => "",
    'wysiwyg_enabled' => false,
);
$installer->addAttribute('catalog_category', 'story_image', $attribute);
$installer->endSetup(); 
?>

<?php 
/*
 * Add custom category attribute for General tab
 * Text Attribute
 */
$installer = new Mage_Sales_Model_Mysql4_Setup;
$attribute  = array(
    'group' => 'General',
    'type' => 'text',
    'label' => 'Story Title',
    'input' => 'text',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'default' => "",
    'wysiwyg_enabled' => false,
);
$installer->addAttribute('catalog_category', 'story_title', $attribute);
$installer->endSetup(); 
?>

<?php 
/*
 * Add custom category attribute for General tab
 * Text Attribute
 */
$installer = new Mage_Sales_Model_Mysql4_Setup;
$attribute  = array(
    'group' => 'General',
    'type' => 'text',
    'label' => 'Story Link Text',
    'input' => 'text',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'default' => "",
    'wysiwyg_enabled' => false,
);
$installer->addAttribute('catalog_category', 'story_link_text', $attribute);
$installer->endSetup();
?>

<?php 
/*
 * Add custom category attribute for General tab
 * Text Attribute
 */
$installer = new Mage_Sales_Model_Mysql4_Setup;
$attribute  = array(
    'group' => 'General',
    'type' => 'text',
    'label' => 'Story Link URL',
    'input' => 'text',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'default' => "",
    'wysiwyg_enabled' => false,
);
$installer->addAttribute('catalog_category', 'story_link_url', $attribute);
$installer->endSetup();
?>

<?php
/*
 * Add custom category attribute for General tab
 * Text Area with WYSIWYG editor
 */
$installer = new Mage_Sales_Model_Mysql4_Setup;
$attribute  = array(
    'group' => 'General',
    'type' => 'text',
    'label' => 'Story Description',
    'input' => 'textarea',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'default' => "",
    'wysiwyg_enabled' => true,
);
$installer->addAttribute('catalog_category', 'story_description', $attribute);
$installer->endSetup(); 

$installer = new Mage_Sales_Model_Mysql4_Setup;
$installer->updateAttribute('catalog_category', 'story_description', 'is_wysiwyg_enabled', 1);
$installer->updateAttribute('catalog_category', 'story_description', 'is_html_allowed_on_front', 1);
?>