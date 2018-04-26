<?php
namespace App\Discounts;

use App\Products;

class CategoryDiscount
{
    const CHEAPEST_DISCOUNT = 20;

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
        $discounts = [];
        if ($this->getTotalQuantityByCategory($categoriesQuantities, 2) >= 5) {
            $discounts[] = ['discount-description' => "Got a sixth product for free from category 'Switches'",
            'discount-value' => $this->getProductFromCategory($categoriesQuantities, 2)['unit-price']];
        }

        if ($this->getTotalQuantityByCategory($categoriesQuantities, 1) >= 2) {
            $cheapestProduct = $this->getCheapestProductFromCategory($categoriesQuantities, 1);
            $discountValue = number_format((float)($cheapestProduct['unit-price'] * (self::CHEAPEST_DISCOUNT / 100)), 2, '.', '');
            $discounts[] = [ 'discount-description' =>"Got a 20% discount on Product ID: ". $cheapestProduct['product-id'] . " from category 'Tools'",
                  'discount-value' => $discountValue];
        }

        return (!empty($discounts)) ? response()->json($discounts) : false;
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
        $product['product-id'] = $productId;
        $product['unit-price'] = $products[$productId];
        return $product;
    }

    /**
     * Get  product from a category and return his info
     *
     * @param $categoriesQuantities
     * @param $categoryId
     * @return mixed
     */
    private function getProductFromCategory($categoriesQuantities, $categoryId)
    {
        foreach ($categoriesQuantities as $category) {
            if ($category['category'] == $categoryId) {
                $product = $category;
                break;
            }
        }

        return $product;
    }
}