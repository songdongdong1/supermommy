define(['jquery',  'mage/url'], function($, url){
   //"use strict";
       var options;
	   var productId;
	   var unitLength;
       return function(_options)
       {
			var ajaxurl = url.build("gd/Index/GetFULLPadvice");
			var qtyFieldSelector ='input.qty';
		   
			$.ajaxSetup({
                type: 'POST',
                headers: { "cache-control": "no-cache" }
			});
		   
		   
			options = _options['option'];
			productId = _options['id'];
			unitLength = _options['unit'];
		   
			console.log(JSON.stringify(_options));
			//console.log(_options['id']);
			//console.log(options['panel']['list']);
			//console.log("before ajax");
			$('#gd_fence_builder_submit').click(function() {
				var gd_pvc_builder_selection_items = [];
				var single_item;
				$('.gd_pvc_builder_selection_item option:selected').each(function(index, element) {
					//console.log("now in the loop");
					//console.log(index);
					
					
					var selectedSkuText = element.textContent;
					
					single_item = {'skuId': element.value, 'skuText':selectedSkuText,'type':element.getAttribute("data-type")};	
					//console.log(single_item);
					gd_pvc_builder_selection_items.push(single_item);
				})
			   
				var gd_pvc_builder_multi_items = [];
				$('.gd_pvc_builder_input_item_text').each(function(index, element) {
					
					//single_item.push(skuId:element.getAttribute("data-sku"));
					//single_item.push(quantity:element.value);
					//single_item.push(type:element.getAttribute("data-type"));
					//single_item.push(typeValue:element.getAttribute("data-value"));
					
					single_item 	= {'skuId':element.getAttribute("data-sku"),'quantity':element.value, 'type':element.getAttribute("data-type"),'typeValue':element.getAttribute("data-value")}
					
					gd_pvc_builder_multi_items.push(single_item);
				   
				})
			   
				console.log(gd_pvc_builder_selection_items);
				console.log(gd_pvc_builder_multi_items);
                var fenceLength		    = $("#gd_fence_builder_length")[0].value;
                
                var gross5indicator     = $("#gd_fence_builder_gross5").is(':checked') ? 1 : 0;
                
    
                console.log(gross5indicator);
               
                var formdata ={fenceConfig:_options,normal: gd_pvc_builder_selection_items,multi:gd_pvc_builder_multi_items,fenceLength: fenceLength,unitLength: unitLength,gross5Indicator:gross5indicator};   
                
                $.ajax({
                url: ajaxurl,
                type: "POST",
                cache:false,
                data: formdata,
                showLoader: true,
                success: function(data){
                    //location.reload();
                    console.log(data);
                    //console.log(data)
                
                    var displayText ="You need:\n" ;
                    var items = data['data'];
					var displayFlag = 1;
                	
					for (let x in items) {
						if (items[x]['qty'] != 0)
							displayFlag = 1;
						
						if (displayFlag){
							displayText += decodeURI(items[x]['title']);
							displayText += " x " ;
							displayText += items[x]['qty'];
							displayText += "\n"
						}
						
						$(items[x]['selector']).val(items[x]['qty']);
						displayFlag = 0;
                    }
                    console.log(displayText);
                    alert(displayText);
					
						
					//$("#bundle-option-17-qty-input").val(3);
                    $(qtyFieldSelector).trigger('change');
            }
        });
          
        });
       }
});