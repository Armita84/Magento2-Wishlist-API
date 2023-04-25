<?php
namespace CustomApi\Wishlist\Api;

interface WishlistManagementInterface
{
    /**
     * Get wishlist items by customer id
     *
     * @param int $customerId
     * @return \Magento\Wishlist\Api\Data\ItemInterface[]
     */
    public function getWishlistItemsByCustomerId($customerId);

    /**
     * Add product to customer wishlist by customer id and product SKU
     *
     * @param int $customerId
     * @param int $productId
     * @param string|null $token
     * @return bool
     */
    public function addProductToWishlist($customerId, $productId);

    /**
     * Remove product from customer wishlist by customer id and product SKU
     *
     * @param int $customerId
     * @param int $productId
     * @return bool
     */
    public function removeProductFromWishlist($customerId, $productId);

    
}
