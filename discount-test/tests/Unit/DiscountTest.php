<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DiscountTest extends TestCase
{

    /**
     * Test ten percent discount
     *
     */
    public function test_Discount_Ten_Percent_Test()
    {
        $headers                 = [];
        $headers['CONTENT_TYPE'] = 'application/json';
        $headers['Accept']       = 'application/json';

        $server = $this->transformHeadersToServerVars($headers);

        $order1 = [
            "id"          => "1",
            "customer-id" => "1",
            "items"       => [
                [
                    "product-id" => "A101",
                    "quantity"   => "70",
                    "unit-price" => "9.75",
                    "total"      => "682.50",
                ],
                [
                    "product-id" => "B102",
                    "quantity"   => "100",
                    "unit-price" => "4.99",
                    "total"      => "499",
                ],
            ],
            "total"       => "1181.50",
        ];

        $response = $this->call('POST', route('discount'), [], [], [], $server, json_encode($order1));

        $response->assertJson([
            'discount-description' => "You got a 10% discount and saved 118.15. Your order will now cost 1063.35.",
            'discount-value'       => 118.15,
        ]);
    }

    /**
     * Test when you buy five, you get a sixth for free.
     *
     */
    public function test_Discount_Product_Free_Test()
    {
        $headers                 = [];
        $headers['CONTENT_TYPE'] = 'application/json';
        $headers['Accept']       = 'application/json';

        $server = $this->transformHeadersToServerVars($headers);

        $order2 = [
            "id"          => "2",
            "customer-id" => "2",
            "items"       => [
                [
                    "product-id" => "B102",
                    "quantity"   => "5",
                    "unit-price" => "4.99",
                    "total"      => "24.95",
                ],
            ],
            "total"       => "24.95",

        ];

        $response = $this->call('POST', route('discount'), [], [], [], $server, json_encode($order2));

        $response->assertJson([['discount-description' => "Got a sixth product for free from category 'Switches'", 'discount-value' => 4.99,]]);
    }

    /**
     * Test when you buy five, you get a sixth for free.
     *
     */
    public function test_Discount_20_Percent_Test()
    {
        $headers                 = [];
        $headers['CONTENT_TYPE'] = 'application/json';
        $headers['Accept']       = 'application/json';

        $server = $this->transformHeadersToServerVars($headers);

        $order3 = [
            "id"          => "3",
            "customer-id" => "3",
            "items"       => [
                [
                    "product-id" => "A101",
                    "quantity"   => "2",
                    "unit-price" => "9.75",
                    "total"      => "19.50",
                ],
                [
                    "product-id" => "A102",
                    "quantity"   => "1",
                    "unit-price" => "49.50",
                    "total"      => "49.50",
                ],
            ],
            "total"       => "69.00",

        ];

        $response = $this->call('POST', route('discount'), [], [], [], $server, json_encode($order3));

        $response->assertJson([['discount-description' => "Got a 20% discount on Product ID: A101 from category 'Tools'", 'discount-value' => 1.95]]);
    }
}
