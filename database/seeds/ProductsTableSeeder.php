<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $savings = Product::create([
            'product_name' => 'Savings Account',
            'slug' => 'savings'
        ]);
        $internal = Product::create([
            'product_name' => 'Internal Account',
            'slug' => 'internal'
        ]);
    }
}
