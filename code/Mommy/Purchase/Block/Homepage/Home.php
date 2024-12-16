<?php
namespace Mommy\Purchase\Block\Homepage;
class Home extends \Magento\Framework\View\Element\Template
{    
  
     /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $_productCollectionFactory;
  
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,        
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
		\Magento\Catalog\Model\CategoryRepository $_categooryRep

    )
    {    
		$this->_categoryRepository 		 = $_categooryRep;
        $this->_productCollectionFactory = $productCollectionFactory;
        parent::__construct($context);
    }
    
    /*
	* get the 
	*/
    public function getProductCollectionByCategories($ids)
    {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addCategoriesFilter(['in' => $ids]);
		//added in 2023,2,16
		$collection->addAttributeToFilter(
			'status',
			array('eq' => 1)
		);
		//end adding
		$collection->setOrder('position','ASC');
        return $collection;
    }
	/*
	$var = categoryid
	*/
	public function getCategoryUrl($id){
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$category = $objectManager->create('Magento\Catalog\Model\Category')->load($id);
		//xdebug_var_dump($category);
		$ImageUrl = $category->getImageUrl();
		//xdebug_var_dump($ImageUrl);
		
		if (!$ImageUrl)
			$ImageUrl = "";
		return $ImageUrl;
		
	}
		

	/*
	@var =$categoryID
	*/
	public function getCategyCollectionByParent($categoryId)
	{
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$category = $objectManager->create('Magento\Catalog\Model\Category')->load($categoryId);
		//$category = $this->categoryRepository->get($categoryId);
		 
		$subCategories = $category->getChildrenCategories();
		//echo "mytest";
		
		
		return $subCategories;
	}
	
	
	
	/*
	@var =$categoryID
	*/
	public function getCategyCollectionByParentIds($categoryIds)
	{
		$subCategories = [];
		
		foreach($categoryIds as $categoryId)
		{		
			$subCategoryList = $this->getCategyCollectionByParent($categoryId);			
			if (count($subCategoryList) == 0)
			{				
				continue;			
			}			
			foreach($subCategoryList as $sub)
			{
				
				$subCategories[]= $sub;
			}
		}
		
		return $subCategories;
	}
	
	/*
	@var =$categoryID
	*/
	public function getCategoryIDByParentIds($categoryIds)
	{
		$subIDS = [];			
		foreach($categoryIds as $categoryId)
		{		
			$subCategoryList = $this->getCategyCollectionByParent($categoryId);						
			foreach($subCategoryList as $sub)
			{
				
				$subIDS[]= $sub->getId();
			}
		}
		
		return $subIDS;
	}
	/*
	
	return ImgUrl
	*/
	public function getProductImgUrl(object $product)
	{
		   //test again
	   //xdebug_var_dump($product_id);
	   $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
	
	   
	   $imagewidth=200;
	   $imageheight=200;
       $imageHelper  = $objectManager->get('\Magento\Catalog\Helper\Image');
       $image_url = $imageHelper->init($product, 'product_page_image_small')->setImageFile($product->getFile())->resize($imagewidth, $imageheight)->getUrl();
       return $image_url;
	}
	/*
	*/
	public function getAttributeName(object $_product, string $type)
	{
		try
		{
			
			return( $_product->getAttributeText($type));
		}
		catch(Exception $e)
		{
			return "";
		}
	}
}