<?php
/**
 * OnePica
 * NOTICE OF LICENSE
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to codemaster@onepica.com so we can send you a copy immediately.
 *
 * @category    Resolve
 * @package     Resolve_Resolve
 * @copyright   Copyright (c) 2014 One Pica, Inc. (http://www.onepica.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/** @var Mage_Core_Model_Resource_Setup $this */
$installer = $this;
$installer->startSetup();

try {
    $setup = Mage::getModel('eav/entity_setup', 'core_setup');

    //--------- catalog_category --------

    $entity = 'catalog_category';

    $attributeCode = 'resolve_category_mfp';
    $attribute = Mage::getModel('catalog/resource_eav_attribute')->loadByCode($entity, $attributeCode);
    if ($attribute->getId()) {
        $setup->updateAttribute($entity, $attributeCode, 'used_in_product_listing', 1);
    }

    $attributeCode = 'resolve_category_mfp_type';
    $attribute = Mage::getModel('catalog/resource_eav_attribute')->loadByCode($entity, $attributeCode);
    if ($attribute->getId()) {
        $setup->updateAttribute($entity, $attributeCode, 'used_in_product_listing', 1);
    }

    $attributeCode = 'resolve_category_mfp_priority';
    $attribute = Mage::getModel('catalog/resource_eav_attribute')->loadByCode($entity, $attributeCode);
    if ($attribute->getId()) {
        $setup->updateAttribute($entity, $attributeCode, 'used_in_product_listing', 1);
    }

    $attributeCode = 'resolve_category_mfp_startdate';
    $attribute = Mage::getModel('catalog/resource_eav_attribute')->loadByCode($entity, $attributeCode);
    if ($attribute->getId()) {
        $setup->updateAttribute($entity, $attributeCode, 'used_in_product_listing', 1);
    }

    $attributeCode = 'resolve_category_mfp_end_date';
    $attribute = Mage::getModel('catalog/resource_eav_attribute')->loadByCode($entity, $attributeCode);
    if ($attribute->getId()) {
        $setup->updateAttribute($entity, $attributeCode, 'used_in_product_listing', 1);
    }

    //--------- catalog_product --------

    $entity = 'catalog_product';

    $attributeCode = 'resolve_product_mfp';
    $attribute = Mage::getModel('catalog/resource_eav_attribute')->loadByCode($entity, $attributeCode);
    if ($attribute->getId()) {
        $setup->updateAttribute($entity, $attributeCode, 'used_in_product_listing', 1);
    }

    $attributeCode = 'resolve_product_mfp_type';
    $attribute = Mage::getModel('catalog/resource_eav_attribute')->loadByCode($entity, $attributeCode);
    if ($attribute->getId()) {
        $setup->updateAttribute($entity, $attributeCode, 'used_in_product_listing', 1);
    }

    $attributeCode = 'resolve_product_mfp_priority';
    $attribute = Mage::getModel('catalog/resource_eav_attribute')->loadByCode($entity, $attributeCode);
    if ($attribute->getId()) {
        $setup->updateAttribute($entity, $attributeCode, 'used_in_product_listing', 1);
    }

    $attributeCode = 'resolve_product_mfp_start_date';
    $attribute = Mage::getModel('catalog/resource_eav_attribute')->loadByCode($entity, $attributeCode);
    if ($attribute->getId()) {
        $setup->updateAttribute($entity, $attributeCode, 'used_in_product_listing', 1);
    }

    $attributeCode = 'resolve_product_mfp_end_date';
    $attribute = Mage::getModel('catalog/resource_eav_attribute')->loadByCode($entity, $attributeCode);
    if ($attribute->getId()) {
        $setup->updateAttribute($entity, $attributeCode, 'used_in_product_listing', 1);
    }



} catch (Exception $e) {
    Mage::logException($e);
}

$installer->endSetup();
