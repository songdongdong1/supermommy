<?php /**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Gd\Skuprice\Controller\Page;
// try to disable CSRF function to receive POST request
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Request\InvalidRequestException;
//end

class Getpricetest extends \Magento\Framework\App\Action\Action implements CsrfAwareActionInterface
{ /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;
    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     */
    public function __construct(
       \Magento\Framework\App\Action\Context $context,
       \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
	
	  
	   )
{
       $this->resultJsonFactory = $resultJsonFactory;
       parent::__construct($context);
}
	public function createCsrfValidationException(RequestInterface $request): ? InvalidRequestException
	{
		return null;
	}
    
	public function validateForCsrf(RequestInterface $request): ?bool
	{
		return true;
	}
    /**
     * View  page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
		$resultJson = $this->resultJsonFactory->create();
      
		$post = $this->getRequest()->getPostValue();
		$storeid  = 2;//$this->getRequest()->getParam("storeid");	
		$sku		 = $this->getRequest()->getParam('sku');	
		$ip = "1.1.1.1";
		$data = json_encode(
				array(
					array("NS16E0397GY",2),
					array("NS16E0398TN",2),
					array("NS16E0396TN",0),
					)
				);

	$options = array(

        CURLOPT_RETURNTRANSFER =>1,         // return web page
		CURLOPT_FOLLOWLOCATION =>1,
	
        CURLOPT_HEADER => 1,
		CURLOPT_HTTPHEADER => array(
			'Content-Type:application/json',
			'Content-Length: ' . strlen($data)
			),
		
        CURLOPT_CUSTOMREQUEST  => 'GET',
        CURLOPT_POSTFIELDS    => $data
		
     

		);
		
		echo $data;
		echo "pre <br>";
		$url  = 'http://dev.patio-paradise.com:8084/api/v1/prices/US/websites/ssd';
        $ch   = curl_init($url);
        curl_setopt_array($ch, $options);
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $location = curl_exec($ch);
		echo $location;
		//echo $location['status'];
		echo "<br>";
		print_r($location);
		if ($location == false){
			
			echo "error:" .curl_error($ch);
		}
        $result   = json_decode($location,true);
        curl_close($ch);
        //echo "test";
		var_dump($result);
		echo "test";
		exit;
		
		
		/*\Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info($data);*/
	    //return $resultJson->setData($data);
/*
    echo "<pre>";
    print_r($post);
    exit;
	*/
	
	
	
	#return $result->setData($data);
	} 
}
