<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use App\Discounts\TotalDiscount;
use App\Discounts\CategoryDiscount;

class DiscountController extends Controller
{
    const MAX_DISCOUNT = 1000;

    /**
     * Get discount messages
     *
     * @return bool|string
     */
    public function getDiscount() {

        if(request('total') > self::MAX_DISCOUNT) {
            $totalDiscount = new TotalDiscount(request('total'));
            return $totalDiscount->getTenPercentDiscount();
        }

        $categoryDiscount = new CategoryDiscount(request('items'));
        if($categoryDiscount->getCategoryDiscount()) {
            return $categoryDiscount->getCategoryDiscount();
        }

        return 'Your order got no discount.';
    }
}