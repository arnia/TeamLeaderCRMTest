<?php
namespace App\Discounts;

use App\Products;

class CategoryDiscount
{

    private $items;

    public function __construct($items)
    {
        $this->items = $items;
    }

    /**
     * Get discount messages based on products category id
     *
     * @return bool|string
     */
    public function getCategoryDiscount()
    {

        $categoriesQuantities = $this->getProductCategoryIds($this->items);
        $discountMessage      = '';

        if ($this->getTotalQuantityByCategory($categoriesQuantities, 2) >= 5) {
            $discountMessage = "Got a sixth product for free from category 'Switches' \n\r";
        }

        if ($this->getTotalQuantityByCategory($categoriesQuantities, 1) >= 2) {
            $discountMessage = $discountMessage . "Got a 20% discount on Product ID: ".
                $this->getCheapestProductFromCategory($categoriesQuantities, 1) . " from category 'Tools' \n\r";
        }

        return ($discountMessage != '') ? $discountMessage : false;
    }

    /**
     * Search for products in database by product-id
     *
     * @param $items
     * @return mixed
     */
    private function getProductCategoryIds($items)
    {
        foreach ($items as $key => $item) {
            $categoryId = Products::where('product_id', $item['product-id'])->firstOrFail()->category;

            $categories[$key]['category'] = $categoryId;
            $categories[$key]['quantity'] = $item['quantity'];
            $categories[$key]['product-id'] = $item['product-id'];
            $categories[$key]['unit-price'] = $item['unit-price'];
        }
        return $categories;
    }

    /**
     * Get total of products by category
     *
     * @param $categoriesQuantities
     * @param $categoryId
     * @return number
     */
    private function getTotalQuantityByCategory($categoriesQuantities, $categoryId)
    {
        $quantity = [];
        foreach ($categoriesQuantities as $category) {
            if ($category['category'] == $categoryId) {
                $quantity[] = $category['quantity'];
            }
        }
        return array_sum($quantity);
    }

    /**
     * Get cheapest product from a category and return his product id
     *
     * @param $categoriesQuantities
     * @param $categoryId
     * @return mixed
     */
    private function getCheapestProductFromCategory($categoriesQuantities, $categoryId)
    {
        foreach ($categoriesQuantities as $category) {
            if ($category['category'] == $categoryId) {
                $products[$category['product-id']] = $category['unit-price'];
            }
        }

        $productId = array_keys($products, min($products))[0];
        return $productId;
    }
}