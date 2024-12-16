<?php
namespace Gd\Skuprice\Controller\Page;
use Magento\Framework\View\Element\Template;

//class Checkorder extends Template
class Checkorder extends \Magento\Framework\App\Action\Action
{
	protected $_orderCollectionFactory;
	protected $resultJsonFactory;
	/**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     */
    public function __construct(
       \Magento\Framework\App\Action\Context $context,
       \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
	   \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactor)
{
       $this->resultJsonFactory = $resultJsonFactory;
	   $this->_orderCollectionFactory  = $orderCollectionFactor; 
       parent::__construct($context);
}
	public function getOrderCollection()
   {
       $collection = $this->_orderCollectionFactory->create()
         ->addAttributeToSelect('*');
         //->addFieldToFilter($field, $condition); //Add condition if you wish
     
     return $collection;
     
    }


   public function getOrderCollectionByCustomerId($customerId)
   {
       $collection = $this->_orderCollectionFactory()->create($customerId)
         ->addFieldToSelect('*')
         ->addFieldToFilter('status',
                ['in' => $this->_orderConfig->getVisibleOnFrontStatuses()]
            )
         ->setOrder(
                'created_at',
                'desc'
            );
 
     return $collection;

    }
   /**
     * View  page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        echo "you are here1";
		
		$collections = $this->getOrderCollection();
		//var_dump ($collections);
		
		
		foreach($collections as $order)
		{
			echo "order";
			echo "<br>";
			foreach ($order->getAllVisibleItems() as $item)
			{
				//print_r($item);
				var_dump($item);
			}
		}
		
		exit;
	}
}
?>