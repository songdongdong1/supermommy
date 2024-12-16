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

class Source extends \Magento\Framework\App\Action\Action implements CsrfAwareActionInterface
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
		\Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,

		\Magento\InventoryCatalogAdminUi\Model\GetSourceItemsDataBySku $sourceDataBySku
	) 	
	{
		
       $this->resultJsonFactory = $resultJsonFactory;
       

		$this->sourceDataBySku = $sourceDataBySku;
		
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
	
	
	public function execute()
	{
		$resultJson = $this->resultJsonFactory->create();
		$sku		 = $this->getRequest()->getParam('sku');
		$data = $this->sourceDataBySku->execute($sku);
		return $resultJson->setData($data);
	
	}
}
