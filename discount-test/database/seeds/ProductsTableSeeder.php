<?php

use Illuminate\Database\Seeder;
use App\Products;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Products::create([
                'product_id' => 'A101',
                'description' => 'Screwdriver',
                'category' => '1',
                'price' => '9.75',
            ]);
        Products::create([
                'product_id' => 'A102',
                'description' => 'Electric screwdriver',
                'category' => '1',
                'price' => '49.50',
            ]);
        Products::create([
                'product_id' => 'B101',
                'description' => 'Basic on-off switch',
                'category' => '2',
                'price' => '4.99',
        ]);
        Products::create([
                'product_id' => 'B102',
                'description' => 'Press button',
                'category' => '2',
                'price' => '4.99',
        ]);
        Products::create([
                'product_id' => 'B103',
                'description' => 'Switch with motion detector',
                'category' => '2',
                'price' => '12.95',
        ]);
    }
}
