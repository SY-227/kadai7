<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create ([
            'company_id' => '1',
            'product_name' => '三ツ矢サイダー',
            'price' => 100,
            'stock' => 10,
        ]);

    }
}
