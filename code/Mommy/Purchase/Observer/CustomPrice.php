<?php
        /**
         * test Hello CustomPrice Observer
         *
         * @category    test
         * @package     test_Hello
         * @author      test 
         *
         */
		namespace Gd\Skuprice\Observer;

        use Magento\Framework\Event\ObserverInterface;
        use Magento\Framework\App\RequestInterface;

        class CustomPrice implements ObserverInterface
        {
            public function execute(\Magento\Framework\Event\Observer $observer) {

			//$reqeustParams = $this->_request->getParams();
			//$customproducttype = $reqeustParams['custom_product_type'];
			$customproducttype = "123";
			\Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info('mytest');
			
		
		
			$item = $observer->getEvent()->getData('quote_item');         
            $item = ( $item->getParentItem() ? $item->getParentItem() : $item );
			
			$options = $item->getProduct()->getTypeInstance(true)->getOrderOptions($item->getProduct());
		
			/*return and pass to magento if no option found*/
			if (!isset($options["options"])){			
			\Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info('returnedtest');
				return $this;
			}
		    
			$customOptions = $options['options'];
			
			
			
		
            $price = "0.0";
            /*test options*/
			//$myVariable = print_r($item, TRUE);
			//$my =xdebug_var_dump($item);
			//exit();
			
			$productType   = $this->getAttributeName($item->getProduct(),"gd_custom_type");
			$productId	   = $item->getProductId();
			$productSku	   = $this->getProductSku($productId);	
			\Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info($productType);
			\Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info("before processing price");
			
			$stream_opts = [
				"ssl" => [
				"verify_peer"=>false,
				"verify_peer_name"=>false,
				]
			];  
			
		    $request_url = "https://www.gardendecorsdepot.com/gd/Page/Test?";
		    $request_url =$request_url . 'sku=' . $productSku ;
		    if (!empty($customOptions)) {
				
				switch($productType)
				{ 
					case "stainless fence":
					
					foreach ($customOptions as $option) {
						$optionTitle = $option['label'];
						$optionId = $option['option_id'];
						$optionType = $option['option_type'];
						$optionValue = $option['option_value'];					
						$sku ="";
						if (!$this->getIsRequire($productId, $optionId))
							continue;
						switch($option['option_type'])
						{
							case 'radio':
								$sku = $this->getProductOptionSku($productId, $optionId, $optionValue);
								break;
							case 'field':
								$sku = sprintf("%02d", $optionValue);
						
						}
					
						$productSku = $productSku . $sku;
					}
						$request_url = "https://www.gardendecorsdepot.com/gd/Page/Test?";
						$request_url =$request_url . 'sku=' . $productSku ;
		    
						break;
					case "grass":
						$request_url = "https://www.gardendecorsdepot.com/gd/Page/Grass?";
						$request_url =$request_url . 'sku=' . $productSku ;
						foreach ($customOptions as $option) {
							
							$optionValue = $option['option_value'];					
							break;
						}
						
						$request_url =$request_url . '&unit=' .$optionValue . '&productId=' .$productId;
						//$productSku ="SS16ER0810BW";
						break;
					default:
						return $this;
				}
			}
			//$request_url = "http://www.sunshadesdepot.com/index.php/skustoreprice?";
			//$request_url =$request_url . 'sku=' . $productSku . '&' . 'storeid=2';
		
			
			\Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info($request_url);
			
			$f =  file_get_contents( $request_url, false,stream_context_create($stream_opts));	
			\Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info("getprice");		
			\Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info($f);	
			$data = json_decode($f,true);
			//\Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info($data);
			
			$price = $data['data']['ship_price'];
			$testprice ="price =" . $price;
			\Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info($testprice);
			$item->setCustomPrice($price);
			$item->setOriginalCustomPrice($price);
			$item->setSku($productSku);
			\Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info($productSku);
			$item->getProduct()->setIsSuperMode(true);
	
			return $this;
        }
		//
		//
		protected function getProductOptionSku($productId,$optionid, $optionValue)
		{
			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			$product = $objectManager->create('Magento\Catalog\Model\Product')->load($productId);
			$sku ="";
			$customOptions = $objectManager->get('Magento\Catalog\Model\Product\Option')->getProductOptionCollection($product);
			
			foreach($customOptions as $key=>$options)
			{
				if($key == $optionid){
					$values = $options->getValues();
					if(isset($values[$optionValue]))
					{
						$sku = $values[$optionValue]['sku'];
					}
				}
			}
			return $sku;
		}
		//
		//
		protected function getIsRequire($productId,$optionid)
		{
			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			$product = $objectManager->create('Magento\Catalog\Model\Product')->load($productId);
			
			$customOptions = $objectManager->get('Magento\Catalog\Model\Product\Option')->getProductOptionCollection($product);
			
			foreach($customOptions as $key=>$options)
			{
				if($key == $optionid){
					return $options->getIsRequire();
			
				}
			}
			return false;
			
		}
		//
		//
		protected function getProductSku($productId)
		{
			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			$product = $objectManager->create('Magento\Catalog\Model\Product')->load($productId);
			$sku = $product->getSku();
			
			return $sku;
		}
		//
		//
		//get attribute by type
		public function getAttributeName($_product,string $type)
        {
                try
                {
                    
                    return( $_product->getAttributeText($type));
                }
                catch(Exception $e)
                {
                    return "";
                }
        }
		//
		// change to curl
		//
		protected function file_get_contents_curl( $url ) {
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_AUTOREFERER, TRUE );
			curl_setopt( $ch, CURLOPT_HEADER, 0 );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $ch, CURLOPT_URL, $url );
			curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE );
			
			$data = curl_exec( $ch );
			
			curl_close( $ch );
			\Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info("in curl content");
			return $data;

		}

}
?>