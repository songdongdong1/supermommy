define(['jquery',
		'Magento_Catalog/js/price-utils',
		'underscore',
		'mage/template'
		], function ($, utils, _, mageTemplate) {
        
     
	 return function (widget) 
	 {
		'use strict';
		
		
        $.widget('mage.priceBox', widget,  {
			
			
			//options: globalOptions, 
			onUpdatePrice: function onUpdatePrice(event, prices) {
		
			//return this._super(event, prices);
			console.log("i am in price box");
			//just for test
			return this._super(event, prices);
			//
			//this.element.trigger('reloadPrice');
			
			if (typeof  prices ==="undefined")
			{
				return this._super(event, prices);
			}
			/*
			console.log(typeof prices["bundle-option-bundle_option"]);
			
			console.log(prices);
			if (typeof prices["bundle-option-bundle_option"] ==="undefined")
			{
				console.log("non bundle product");
				return  this._super(event, prices);;
			}
            if (typeof prices["bundle-option-bundle_option"] != 'undefined')
			{
				console.log("bundle prduct")
				//if this called inside bundeled product then call parent's method
				return  this._super(event, prices);;
			}
			*/
			this.reloadPrice(prices);

				
			
			},
			
			reloadPrice: function (prices)
			{
				
				console.log("call me in reload price");
				console.log(prices);
				console.log(JSON.stringify(prices));
				console.log("this . option");
				console.log(this.options);
				return this._super(prices);
				
				var count = 0;
				var priceFormat = (this.options.priceConfig && this.options.priceConfig.priceFormat) || {},
                priceTemplate = mageTemplate(this.options.priceTemplate);
				
				var prices_key = Object.keys(prices)[0];
				console.log(prices_key);
				if (prices_key.includes("bundle-option-bundle"))
				{
					console.log("bundle product");
					var prices1 = prices[prices_key]["finalPrice"]["amount"];
					prices = prices1;
				}
				console.log("price=");
				console.log(prices);
				console.log(this.cache.displayPrices);
				_.each(this.cache.displayPrices, function (price, priceCode)
				{
				//var prices =100;
				console.log("nochanged price=");
		
				price.final = prices;
				
				console.log(price);
				
				price.formatted = utils.formatPrice(price.final, priceFormat);
				
				console.log("iam" + count++);
				//baseoldPrice
				//oldPrice
				//basePrice
				//finalPrice
				console.log(price);
				console.log("$=");
                console.log($('[data-price-type="' + priceCode+ '"]', this.element).html(priceTemplate({
                    data: price
                })));
				},this);
           
			}
		/*eslint-disable no-extra-parens*/
        /**
         * Render price unit block.
         */
		 /*
        reloadPrice: function reDrawPrices(price1) {
            var priceFormat = (this.options.priceConfig && this.options.priceConfig.priceFormat) || {},
                priceTemplate = mageTemplate(this.options.priceTemplate);
			console.log("input price=");
			console.log(price1);
            _.each(this.cache.displayPrices, function (price, priceCode) {
                price.final = price1;

                price.formatted = utils.formatPrice(price.final, priceFormat);
				console.log("price=");
				console.log(price);
                $('[data-price-type="' + priceCode + '"]', this.element).html(priceTemplate({
                    data: price
                }));
            }, this);
        },
		*/
			
		});
		
		console.log("hi");
        return $.mage.priceBox;
		
	 }
}
);