define([
    'jquery',
    'Magento_Catalog/js/product/breadcrumbs',
    'jquery/ui'
], function ($) {
    'use strict';
    return function (widget) {
        $.widget('mage.breadcrumbs', widget, {
            /**
             * {@inheritdoc}
             */
            _getCategoryCrumb: function (menuItem) {
                //do something here
			    menuItem.textContent = "mydaddy" + menuItem.text();
				alert("me");
                return this._super(menuItem);
            },
        });
        return $.mage.breadcrumbs;
		
    };
});