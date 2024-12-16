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
       $result = $this->resultJsonFactory->create();
       $data = ['message' => 'Hello world!'];
	   $post = $this->getRequest()->getPostValue();
	   $request  = $this->getRequest()->getParam("id");	   	   	   
	   echo "<pre>";
	   echo "test:end-";
	   print_r($post);
	   
	   //test again
	   $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
	   $product = $objectManager->create('Magento\Catalog\Model\Product')->load("10");
	   echo $product->getThumbnail();
       echo  $product->getProductUrl();
	   $imagewidth=200;
	   $imageheight=200;
       $imageHelper  = $objectManager->get('\Magento\Catalog\Helper\Image');
       $image_url = $imageHelper->init($product, 'product_page_image_small')->setImageFile($product->getFile())->resize($imagewidth, $imageheight)->getUrl();
       echo $image_url;
	   //	   $this->_logger->log(100, "test1234");
	   \Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info('msg 1111toprint');

	   exit();
/*
    echo "<pre>";
    print_r($post);
    exit;
	*/
	
	
	
#return $result->setData($data);
} }
