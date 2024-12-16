<?php 

namespace Mommy\Purchase\Block\Rewrite\Html\Header;

class Logo extends \Magento\Theme\Block\Html\Header\Logo
{
    /**
     * Current template name
     *
     * @var string
     */
	protected $_storeInfo;
	protected $_storeManager;
    protected $_template = 'Mommy_Purchase::html/header/logo.phtml';
	//protected $store;
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
        \Magento\MediaStorage\Helper\File\Storage\Database $fileStorageHelper,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Store\Model\Information $storeInfo,
		array $data = []
    ) 
	{
		//array $data =[];
        $this->_storeInfo = $storeManager;
		$this->_storeManager = $storeManager;
		
        parent::__construct($context,$fileStorageHelper, $data);
    }	
	//
	//
	//
	public function getPhoneNumber()
	{
		
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();

		$storeInformation = $objectManager->create('Magento\Store\Model\Information');

		$store = $objectManager->create('Magento\Store\Model\Store');

		$storeInfo = $storeInformation->getStoreInformationObject($store);

		$phone = $storeInfo->getPhone();
		return $phone;
	}
}