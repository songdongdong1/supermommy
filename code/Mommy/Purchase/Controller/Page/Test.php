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

class Test extends \Magento\Framework\App\Action\Action implements CsrfAwareActionInterface
{
    /**
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
		$request_url = "http://www.sunshadesdepot.com/index.php/skustoreprice?";	
   		$request_url = $request_url .'storeid=' . $storeid . "&&" . 'sku=' .$sku;				
		//echo $request_url;
	    $f = file_get_contents( $request_url);		
	    //echo '<br>';		
		//echo $f;	   
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$product = $objectManager->create('Magento\Catalog\Model\Product')->load("10");
	    //	   $this->_logger->log(100, "test1234");
		\Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info("Page/Test");
		$data = json_decode($f);
		/*\Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info($data);*/
	    return $resultJson->setData($data);
/*
    echo "<pre>";
    print_r($post);
    exit;
	*/
	
	
	
	#return $result->setData($data);
	} 
}
