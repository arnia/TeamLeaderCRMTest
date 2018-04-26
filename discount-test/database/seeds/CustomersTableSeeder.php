<?php

use Illuminate\Database\Seeder;
use App\Customers;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customers::create(
            [
                'name' => 'Coca Cola',
                'since' => '2014-06-28',
                'revenue' => '492.12',
            ]);

        Customers::create(
            [
                'name' => 'Teamleader',
                'since' => '2015-01-15',
                'revenue' => '1505.95',
            ]);

        Customers::create(
            [
                'name' => 'Jeroen De Wit',
                'since' => '2016-02-11',
                'revenue' => '0.00',
            ]
        );
    }
}
