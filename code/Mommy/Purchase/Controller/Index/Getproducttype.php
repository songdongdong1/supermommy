<?php
namespace Jesadiya\ProductType\Model;
 
use Psr\Log\LoggerInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
 
class ProductType
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;
 
    /**
     * @var LoggerInterface
     */
    private $logger;
 
    public function __construct(
        LoggerInterface $logger,
        ProductRepositoryInterface $productRepository
    ) {
        $this->logger = $logger;
        $this->productRepository = $productRepository;
    }
 
    /**
     * Product type
     *
     * @param int $productId
     * @return string|null
     */
    public function getProductType($productId)
    {
        $productType = null;
        try {
            $productType = $this->productRepository->getById($productId)->getTypeId();
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
        }
 
        return $productType;
    }
}