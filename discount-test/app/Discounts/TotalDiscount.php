<?php

namespace App\Discounts;

class TotalDiscount
{
    private $total;
    const DISCOUNT = 10;

    public function __construct($total) {
        $this->total = $total;
    }

    /**
     * Get the ten percent discount message
     *
     * @return string
     */
    function getTenPercentDiscount() {
        $discountTotal = $this->total * (self::DISCOUNT / 100);
        $discountedPrice = $this->total - $discountTotal;

        return response()->json(['discount-description' => "You got a " . self::DISCOUNT . "% discount and saved " . $discountTotal . ". Your order will now cost " . $discountedPrice . ".",
        'discount-value' => $discountTotal]);
    }
}