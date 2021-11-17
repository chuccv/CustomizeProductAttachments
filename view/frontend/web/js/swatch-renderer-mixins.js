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
 * @package     Mageplaza_ConfigurablePreselect
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

define([
    'jquery',

    /** use to initialize the price-box so that it will update price when auto-select
     * the reason: in module-swatches/view/frontend/templates/product/listing/renderer.phtml
     * swatch-renderer is loaded before price-box AND doesn't have the auto-select
     * when this extension enable, with this approach (mixin)
     * -> auto-select enable -> select attributes before price-box load -> price is not updated accordingly
     * With layered, price-box is loaded before swatch-renderer
     */

    'Magento_Catalog/js/price-box'
], function ($) {
    'use strict';

    return function (widget) {
        $.widget('mage.SwatchRenderer', widget, {
            /**
             * Event listener
             *
             * @private
             */
            _EventListener: function () {
                var $widget = this,
                    options = this.options.classes,
                    target;

                $widget.element.on('click', '.' + options.optionClass, function () {
                    var size = $('.swatch-attribute.size').attr('data-option-selected'),
                        color = $('.swatch-attribute.color').attr('data-option-selected');
                    if (size && color) {
                        $('.mp-attachment-tab__item').each(function () {
                            if ($(this).data('color') == color && $(this).data('size') == size) {
                                $(this).show();
                            }else {
                                $(this).hide();
                            }
                        });
                    }else {

                    }

                });

                $widget.element.on('change', '.' + options.selectClass, function () {
                    var size = $('.swatch-attribute.size').attr('data-option-selected'),
                        color = $('.swatch-attribute.color').attr('data-option-selected');
                    if (size && color) {
                        $('.mp-attachment-tab__item').each(function () {
                            if ($(this).data('color') == color && $(this).data('size') == size) {
                                $(this).show();
                            }else {
                                $(this).hide();
                            }
                        });
                    }
                });
                this._super();
            }
        });

        return $.mage.SwatchRenderer;
    };
});
