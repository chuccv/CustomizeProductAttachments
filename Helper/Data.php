<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_ProductAttachments
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\CustomizeProductAttachments\Helper;

/**
 * Class Data
 * @package Mageplaza\ProductAttachments\Helper
 */
class Data extends \Mageplaza\ProductAttachments\Helper\Data
{
    /**
     * Get file list in each product ( in frontend )
     *
     * @param int $productId
     * @param string $group
     * @param bool $isFrontend
     * @param array $groupValue
     *
     * @return Collection
     */
    public function getFileByProduct($productId, $group = '', $isFrontend = false, $groupValue = [], $product = null)
    {
        $fileCollection = $this->getFileCollection();
        if ($product !== null && $product->getTypeId() === 'configurable') {
            $_children = $product->getTypeInstance()->getUsedProducts($product);
            $sql = '';
            foreach ($_children as $index => $item) {
                $sql .= 'product.entity_id=' . $item->getId() . ' OR ';
            }
            $fileCollection->join(
                ['product' => $fileCollection->getTable('mageplaza_productattachments_file_product')],
                'main_table.file_id=product.file_id AND (' . $sql . ' product.entity_id=' . $productId . ')'
            );

        } else
            $fileCollection->join(
                ['product' => $fileCollection->getTable('mageplaza_productattachments_file_product')],
                'main_table.file_id=product.file_id AND product.entity_id=' . $productId
            );

        if ($group === 'others') {
            $condition = [['null' => true], ['eq' => '']];
            if (!empty($groupValue)) {
                array_push($condition, ['nin' => $groupValue]);
            }

            $groups = $this->getGroups();
            $options = $groups ? Data::jsonDecode($groups) : [];

            if (isset($options['option']['value']) && !empty($options['option']['value'])) {
                $fileCollection->addFieldToFilter('main_table.group', $condition);
            }
        } elseif ($group && $isFrontend) {
            $fileCollection->addFieldToFilter('main_table.group', $group);
        }

        return $fileCollection;
    }
    //dddd
    //EE
}
