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

namespace Mageplaza\CustomizeProductAttachments\Block\Product;

/**
 * Class Attachments
 * @package Mageplaza\CustomizeProductAttachments\Block\Product
 */
class Attachments extends \Mageplaza\ProductAttachments\Block\Product\Attachments
{
    public function getFileList($group, $groupValue = [])
    {
        $product = $this->getProduct();

        if (method_exists($product, 'getId')) {
            $productId = $product->getId();

            return $this->helperData->getFileByProduct($productId, $group, true, $groupValue, $product);
        }

        return [];
    }

    public function getProductId()
    {
        return $this->getProduct()->getId();
    }

    /**
     * @param $productId
     * @return array
     */
    public function getMpAttributeValue($productId)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        try {
            $product = $objectManager->get('Magento\Catalog\Model\Product')->load($productId);
        } catch (\Exception $e) {
        }

        if ($product->getTypeId() !== 'simple') {
            $data['color'] = '';
            $data['size'] = '';

        } else {
            $data['color'] = $product->getColor();
            $data['size'] = $product->getSize();
        }

        return $data;
    }

}
