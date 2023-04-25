<?php
namespace CustomApi\Wishlist\Model;

use CustomApi\Wishlist\Api\WishlistManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
// use Magento\Wishlist\Api\WishlistRepositoryInterface;
use Magento\Wishlist\Model\ItemFactory;
use Magento\Wishlist\Model\WishlistFactory;
use Psr\Log\LoggerInterface;
use Magento\Framework\Exception\LocalizedException;

class WishlistManagement implements WishlistManagementInterface
{
     /**
     * @var LoggerInterface
     */
    protected $_logger;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var WishlistRepositoryInterface
     */
    protected $wishlistRepository;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var WishlistFactory
     */
    protected $wishlistFactory;

    /**
     * @var ItemFactory
     */
    protected $wishlistItemFactory;

   

    public function __construct(
        // WishlistRepositoryInterface $wishlistRepository,
        LoggerInterface $logger,
        ProductRepositoryInterface $productRepository,
        WishlistFactory $wishlistRepository,
        CustomerRepositoryInterface $customerRepository,
        WishlistFactory $wishlistFactory,
        ItemFactory $wishlistItemFactory
       
    ) {
        $this->_logger = $logger;
    	$this->productRepository = $productRepository;
        $this->wishlistRepository = $wishlistRepository;
        $this->customerRepository = $customerRepository;
        $this->wishlistFactory = $wishlistFactory;
        $this->wishlistItemFactory = $wishlistItemFactory;
       
    }

    /**
     * Get wishlist items by customer id
     *
     * @param int $customerId
     * @return \Magento\Wishlist\Api\Data\ItemInterface[]
     */
    public function getWishlistItemsByCustomerId($customerId)
    {
        $result = [];
        $wishlist = $this->wishlistFactory->create();
        $wishlist->loadByCustomerId($customerId, true);
        $wishlistItems = $wishlist->getItemCollection();

        foreach ($wishlistItems as $item) {
            $product = $item->getProduct();
            $result[] = [
                'item_id' => $item->getId(),
                'product_id' => $item->getProductId(),
                'sku' => $product->getSku(),
                'name' => $product->getName(),
                // 'price' => $product->getPrice(),
                'qty' => $item->getQty(),
            ];
        }

    return $result;
    }

   /**
     * Add product to customer wishlist by customer id and product SKU
     *
     * @param int $customerId
     * @param int $productId
     * @return bool
     */
    public function addProductToWishlist($customerId, $productId)
  
   

   {

   		if ($productId == null) {
            throw new LocalizedException(__
            ('Invalid product, Please select a valid product'));
        }
        try {
            $product = $this->productRepository->getById($productId);
        } catch (NoSuchEntityException $e) {
            $product = null;
        }
        try {
            $wishlist = $this->wishlistRepository->create()->loadByCustomerId
            ($customerId, true);
            $wishlist->addNewItem($product);
            $returnData = $wishlist->save();
        } catch (NoSuchEntityException $e) {

        }
        return true;
	   
    }

/**
 * Remove product from customer wishlist by customer id and product SKU
 *
 * @param int $customerId
 * @param int $productId
 * @return bool
 */
	public function removeProductFromWishlist($customerId, $productId)
	{
	    $wishlist = $this->wishlistFactory->create()->loadByCustomerId($customerId);
		$product = $this->productRepository->getById($productId);
		$items = $wishlist->getItemCollection();
		foreach ($items as $item) {
		    if ($item->getProductId() == $productId) {
		        try {
		            $item->delete();
		            return true;
		        } catch (CouldNotSaveException $e) {
		            return false;
		        }
		    }
		}
		return false;
	}
	

}