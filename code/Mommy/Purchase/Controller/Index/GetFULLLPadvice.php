<?php /**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Gd\Skuprice\Controller\Index;
// try to disable CSRF function to receive POST request
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Request\InvalidRequestException;
//end

class GetFULLPadvice extends \Magento\Framework\App\Action\Action implements CsrfAwareActionInterface
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
	   
	   \Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info('msg toprint');

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
		$post = $this->getRequest()->getPost();
		$request  = $this->getRequest()->getParam("id");
		
		xdebug_var_dump($post);
		exit();
		//POST, panel, u-channel, CAPS, ALUM, gate
		//xdebug_var_dump($post);
	    //echo $post["panel_list"]
		//--skuId
		//--productTitle
		//--length
		//--preffered
		//echo $post["post_list"]
		//--skuId
		//--productTitle
		//--postType
		//----line
		//----corner
		//----end
		//
		//echo $post["caps"]
		//--skuId
		//--productTitle
		//echo $post["accessories"]
		//--skuId
		//--productTitle
		//--accessory category
		//echo $post["fenceLength"]
		//--length of fence
		//echo $post["gross5Indicator"]
		//gross 5 indicator
	
	
	
	
	
		//5% increase indicator
		$gross5Indicator =$post["gross5Indicator"];
		//total fence lenght
    	$fenceLength =  $post['fenceLength'];
		//length for the one set of fence
		$unitLength  =  $post['unitLength'];
        
		
		//
		//Fence config per set eg.
		//  $fenceConfig['panel'] 		== #number of panel per set
		//	$fenceConfig['post']  		== #number of post  per set
		//  $fenceConfig['cap']   		== #number of caps  per set
		//  $fenceConfig['rail']		== #number of rails per set
		//  $fenceConfig['u-channel']	== #number of u-channel
		$fenceConfig = $post['fenceConfig'];
		
        //check if introduce %5 increase of the length of fence 
           
        if ($gross5Indicator)
            $fenceLength = $fenceLength *1.05;
        
		//init length to zero
		
		$data = array("result"=>"0");
							
		$resultJson = $this->resultJsonFactory->create();
       
        
		if ($unitLength <=  0)
			return $resultJson->setData($data);
	    
	  
	   
	   
		$unitNumber = intval($fenceLength/$unitLength);
		$unitRemainingLength = intval($fenceLength - ($unitNumber * $unitLength));
      
        if ($unitRemainingLength >0 )
				$unitNumber++;
		
        $data = array("result"=>"1", "data"=>[array("skuId"=>$post['skuId'], "unitNumber"=>$unitNumber)]
					);
        
		return $resultJson->setData($data);

	   
    /*
    print_r($post);
    exit;
	*/
	
	
	
#return $result->setData($data);
} }
