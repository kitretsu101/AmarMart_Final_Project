<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@amarmart.test'],
            [
                'name' => 'AmarMart Admin',
                'password' => 'password',
                'is_admin' => 1,
            ]
        );

        $products = [
            ['name' => 'Rice 5kg', 'description' => 'Premium aromatic rice pack for daily cooking.', 'price' => 720, 'stock' => 40],
            ['name' => 'Mustard Oil 1L', 'description' => 'Cold-pressed mustard oil bottle.', 'price' => 310, 'stock' => 55],
            ['name' => 'Green Tea Box', 'description' => '25 biodegradable tea bags.', 'price' => 180, 'stock' => 70],
            ['name' => 'Honey 500g', 'description' => 'Natural pure honey jar.', 'price' => 450, 'stock' => 35],
            ['name' => 'Notebook A5', 'description' => 'Ruled notebook for office and school.', 'price' => 90, 'stock' => 100],
            ['name' => 'USB Cable', 'description' => 'Fast charging USB-C cable 1 meter.', 'price' => 250, 'stock' => 60],
            ['name' => 'Hand Soap', 'description' => 'Mild liquid hand soap 250ml.', 'price' => 140, 'stock' => 80],
            ['name' => 'Ceramic Mug', 'description' => 'Matte finish coffee mug.', 'price' => 220, 'stock' => 45],
        ];

        foreach ($products as $item) {
            Product::query()->updateOrCreate(
                ['slug' => str($item['name'])->slug()->toString()],
                [
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'stock' => $item['stock'],
                    'is_active' => 1,
                ]
            );
        }
    }
}
