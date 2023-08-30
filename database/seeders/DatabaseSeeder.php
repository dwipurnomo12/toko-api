<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductGallery;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Product::create([
            'name'          => 'Adidas Red',
            'price'         => 450000,
            'description'   => 'Description Of Adidas Red',
            'tags'          => 'sports',
            'category_id'   => 1,
            'gallery_id'    => 1
        ]);

        ProductCategory::create([
            'name'  => 'sport',
        ]);

        ProductGallery::create([
            'product_id'    => 1,
            'url'           => 'wdwfdwfwfwfwfwfg'
        ]);

        Transaction::create([
            'address'           => 'Purworejo',
            'total_price'       => 750000,
            'shipping_price'    => 0,
            'status'            => 'pending',
            'payment'           => 'Midtrans',
            'user_id'           => 1
        ]);

        TransactionDetail::create([
            'quantity'       => 2,
            'user_id'        => 1,
            'product_id'     => 1,
            'transaction_id' => 1,
        ]);
    }
}
