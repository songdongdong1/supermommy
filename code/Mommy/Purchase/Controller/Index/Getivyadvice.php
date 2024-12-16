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

class Getivyadvice extends \Magento\Framework\App\Action\Action implements CsrfAwareActionInterface
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
		//xdebug_var_dump($post);
	   
		//echo $post['skuId'];
		//echo $post['skuText'];
		//echo $post['fenceLength'];
		$gross5Indicator =$post["gross5Indicator"];
        
		$fenceLength =  $post['fenceLength'];
		
        
        //check if introduce %5 increase of the length of fence 
           
        if ($gross5Indicator)
            $fenceLength = $fenceLength *1.05;
        
		//init length to zero
		$unitLength = 0;
		
	    switch($post['skuId']){
			case 'GDALLLIN0608':
			$unitLength = 8;
			break;
			case 'GDALLLIN0610':
			$unitLength = 10;
			break;
			case 'GDALLLIN0612':
			$unitLength = 12;
			break;
			case 'GDALLLIN0614':
			$unitLength = 14;
			break;
		}
	   
		$data = array("result"=>"0");
							
		$resultJson = $this->resultJsonFactory->create();
       
        
		if ($unitLength ===  0)
			return $resultJson->setData($data);
	    
	  
	   
	   
		$unitNumber = intval($fenceLength/$unitLength);
		$unitRemainingLength = intval($fenceLength - ($unitNumber * $unitLength));
      
        $remainingSku     ="";
        
		if ($unitRemainingLength <= 8 )
			$remainingSku = 'GDALLLIN0608';
		elseif($unitRemainingLength <= 10)
			$remainingSku = 'GDALLLIN0610';
		elseif($unitRemainingLength <= 12)
			$remainingSku = 'GDALLLIN0612';
		else					
			$remainingSku = 'GDALLLIN0614';
		//xdebug_var_dump($remainingSku);
        //xdebug_var_dump($unitRemainingLength);
        if ($unitRemainingLength ==0)
        {
            $data = array("result"=>"1", "data"=>[array("skuId"=>$post['skuId'], "unitNumber"=>$unitNumber)]
					);
        }
		elseif ($remainingSku == $post['skuId'])
		{
			$unitNumber++;
			$data = array("result"=>"1", "data"=>[array("skuId"=>$post['skuId'], "unitNumber"=>$unitNumber)]
					);
		}
		else
			$data = array("result"=>"1", "data"=>[  array("skuId"=>$post['skuId'], "unitNumber"=>$unitNumber),
                                                    array("skuId"=>$remainingSku, 'unitNumber'=>'1')]
                    );
        
		return $resultJson->setData($data);

	   
    /*
    print_r($post);
    exit;
	*/
	
	
	
#return $result->setData($data);
} }
