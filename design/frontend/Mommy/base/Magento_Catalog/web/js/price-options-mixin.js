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

              _onOptionChanged: function () {
                alert("This was called instead of the parent _onOptionChanged function");
            }

        });
		alert("hi");
        return $.mage.priceOptions;
    }
});