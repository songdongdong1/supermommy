define(['jquery',
    'Magento_Catalog/js/price-utils',
    'underscore',
    'mage/template',
    'jquery-ui-modules/widget'], function ($, utils, _, mageTemplate) {
        'use strict';
        var globalOptions = {
        optionTemplate: '<%= data.label %>' +
        '<% if (data.finalPrice.value > 0) { %>' +
        ' <%- data.finalPrice.formatted %>' +
        '<% } else if (data.finalPrice.value < 0) { %>' +
        ' <%- data.finalPrice.formatted %>' +
        '<% } %>',
       };
        $.widget('mage.priceBox',  {
			
			options: globalOptions, 

            _updatePrice: function updatePrice(newPrices) {
			console.log("i am in price box");
            var prices = this.cache.displayPrices,
                additionalPrice = {},
                pricesCode = [],
                priceValue, origin, finalPrice;

            this.cache.additionalPriceObject = this.cache.additionalPriceObject || {};

            if (newPrices) {
                $.extend(this.cache.additionalPriceObject, newPrices);
            }

            if (!_.isEmpty(additionalPrice)) {
                pricesCode = _.keys(additionalPrice);
            } else if (!_.isEmpty(prices)) {
                pricesCode = _.keys(prices);
            }

            _.each(this.cache.additionalPriceObject, function (additional) {
                if (additional && !_.isEmpty(additional)) {
                    pricesCode = _.keys(additional);
                }
                _.each(pricesCode, function (priceCode) {
                    priceValue = additional[priceCode] || {};
                    priceValue.amount = +priceValue.amount || 0;
                    priceValue.adjustments = priceValue.adjustments || {};

                    additionalPrice[priceCode] = additionalPrice[priceCode] || {
                            'amount': 0,
                            'adjustments': {}
                        };
                    additionalPrice[priceCode].amount =  0 + (additionalPrice[priceCode].amount || 0) +
                        priceValue.amount;
                    _.each(priceValue.adjustments, function (adValue, adCode) {
                        additionalPrice[priceCode].adjustments[adCode] = 0 +
                            (additionalPrice[priceCode].adjustments[adCode] || 0) + adValue;
                    });
                });
            });

            if (_.isEmpty(additionalPrice)) {
                this.cache.displayPrices = utils.deepClone(this.options.prices);
            } else {
                _.each(additionalPrice, function (option, priceCode) {
                    origin = this.options.prices[priceCode] || {};
                    finalPrice = prices[priceCode] || {};
                    option.amount = option.amount || 0;
                    origin.amount = origin.amount || 0;
                    origin.adjustments = origin.adjustments || {};
                    finalPrice.adjustments = finalPrice.adjustments || {};

                    finalPrice.amount = 0 + origin.amount + option.amount;
                    _.each(option.adjustments, function (pa, paCode) {
                        finalPrice.adjustments[paCode] = 0 + (origin.adjustments[paCode] || 0) + pa;
                    });
                }, this);
            }

            this.element.trigger('reloadPrice');
			}
		});
	    console.log("hi");
        return $.mage.priceOptions;
		
    }
);