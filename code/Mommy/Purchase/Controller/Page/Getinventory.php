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

class Getinventory extends \Magento\Framework\App\Action\Action implements CsrfAwareActionInterface
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
		//MFS22E0604	   		
		$request_url = "http://71.83.187.126:8010/gdd/data_gd.jsp?type=inventory";
		//$request_url = $request_url .'storeid=' . $storeid . "&&" . 'sku=' .$sku;				
		//echo $request_url;
	    $f = file_get_contents( $request_url);		
	    //echo '<br>';		
		//echo $f;	   
		$data = json_decode($f, true);
	   
		\Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info("Page/Inventory");
		if ($data['status'] == 0)
		{
			
			foreach($data['datas'] as $dataitem)
			{
				echo "<br>";
				echo "product code:" . $dataitem["productcode"] . "---";
				echo "price in LA" . ":" . $dataitem['pri_ca'] . "----";
				echo "Inventory" . "=" . $dataitem['inv_ca'];
				echo "price in Houston" . ":" . $dataitem['pri_tx'] . "----";
				echo "Inventory" . "=" . $dataitem['inv_tx'];
			    echo "price in RV" . ":" . $dataitem['pri_rv'] . "----";
				echo "Inventory" . "=" . $dataitem['inv_rv'];
				echo "Status:";
				echo "---";
				echo  $dataitem["sta_ca"]==0 ? "In stock at LA": "Out stock at LA";
				echo "---";
				echo  $dataitem["sta_tx"]==0 ? "In stock at Houston": "Out stock at Houston";
				echo "---";
				echo  $dataitem["sta_rv"]==0 ? "In stock at RV": "Out stock at RV";
				
			
		
			}
			
		}
		else echo "Failed to get the inventory data";
		
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