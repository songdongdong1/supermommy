<?php /**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Gd\Skuprice\Controller\Page;
// try to disable CSRF function to receive POST request
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\InventoryApi\Api\SourceItemsSaveInterface;
use Magento\InventoryApi\Api\Data\SourceItemInterfaceFactory;
//end

class Sourceset extends \Magento\Framework\App\Action\Action implements CsrfAwareActionInterface
{
	 /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;
	protected $_sourceItemsSaveInterface;

	protected $_sourceItemFactory;
	protected $sourceDataBySku;
    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     */
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,

		\Magento\InventoryCatalogAdminUi\Model\GetSourceItemsDataBySku $sourceDataBySku,
		SourceItemsSaveInterface $sourceItemsSaveInterface,
		SourceItemInterfaceFactory $sourceItemFactory
	) 	
	{
		
		$this->resultJsonFactory = $resultJsonFactory;
        $this->_sourceItemsSaveInterface = $sourceItemsSaveInterface;
		$this->_sourceItemFactory = $sourceItemFactory;

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
		$resultJson 	= $this->resultJsonFactory->create();
		$sku		 	= $this->getRequest()->getParam('sku');
		$source 		= $this->getRequest()->getParam('source');
		$quantity 		= $this->getRequest()->getParam('qty');
		
		//create the sourceItem using the factory
		$sourceItem = $this->_sourceItemFactory->create();
		$sourceItem->setSourceCode($source);
		$sourceItem->setSku($sku);
		$sourceItem->setQuantity(51);
		$sourceItem->setStatus(1);
		
		$sourceItem->setPrice(2226.50);
		//logs
		\Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info($source);
		//pass the sourceItem as an array element, you can add more source items in the same call as further array elements
		$data = $this->_sourceItemsSaveInterface->execute([$sourceItem]);
		
		return $resultJson->setData($data);
	
	}
}
