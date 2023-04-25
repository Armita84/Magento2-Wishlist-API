# Magento2-Wishlist-API
## Get, Add and Remove items for a Customer's wishlist in Magento2 Using REST API

# Installation:
1- Download the Repository File. 

2- Unzip the file (in case you downloded a Zip format) and upload the **"CustomApi"** folder into **app/code** directory of the Magento. 

3- Use the below commands to install and enable the module:

    * php bin/magento setup:upgrade
    * php bin/magento setup:di:compile
    * php bin/magento cache:flush
    
# Working with API:
1- **Get Wishlist Items**
You can use the below API in 'GET' method to get All wishlist items of a customer on your Magento store:

**[Your store URL]/rest/V1/wishlist/customer/items?customerId={customer id}**
Note: Replace {customer id} with the actual id of the customer. You can use 'Customer Bearer Token' for authentication also.

2- **Add a product to the Wishlist** 
For adding an item to a customer wishlist, use 'POST' method in the below API:

**[Your store URL]/rest/V1/wishlist/customer/product/{customer id}/{product id}**
Note: Replace {customer id} and the {product id} with the actual id of the customer and the product you want to add to the wishlist. 

3- **Remove a product from the Wishlist**
In order to remove an item from a customer wishlist, use 'DELETE' method in the below API:

**[Your store URL]/rest/V1/wishlist/customer/item/{customer id}/{product id}**
Note: Replace {customer id} and the {product id} with the actual id of the customer and the product you want to remove from the wishlist. 

I hope it helps. 



