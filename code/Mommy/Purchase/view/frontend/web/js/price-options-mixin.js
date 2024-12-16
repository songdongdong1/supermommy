define(['jquery'], function ($) {


    return function (widget) {
        'use strict';
        var globalOptions = {
        optionTemplate: '<%= data.label %>' +
        '<% if (data.finalPrice.value > 0) { %>' +
        ' <%- data.finalPrice.formatted %>' +
        '<% } else if (data.finalPrice.value < 0) { %>' +
        ' <%- data.finalPrice.formatted %>' +
        '<% } %>',
       };
        $.widget('mage.priceOptions', widget, {

            _onOptionChanged: function (event) {
				var changes,
                option = $(event.target),
                handler = this.options.optionHandlers[option.data('role')];
				console.log("this");
				console.log(this);
				console.log("change option");
				console.log(option);
				console.log("this->option");
				console.log(this.options);
				console.log("handler");
				console.log(handler);
			  
			  
				var prices = 1020;
				return $(this.options.priceHolderSelector).trigger('updatePrice',  prices);
			  //return this._super(event);
			  
            }

        });
	    console.log("hi");
        return $.mage.priceOptions;
    }
});