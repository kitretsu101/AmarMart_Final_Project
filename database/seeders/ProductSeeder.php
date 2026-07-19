<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Seed sample products.
     */
    public function run(): void
    {
        $products = [
            [
                'name'        => 'Samsung Galaxy A55',
                'description' => 'The Samsung Galaxy A55 features a 6.6-inch Super AMOLED display, 50MP triple camera, and a powerful Exynos 1480 processor. Ideal for everyday use with long battery life.',
                'price'       => 45000.00,
                'stock'       => 25,
                'image'       => null,
            ],
            [
                'name'        => 'Apple iPhone 14',
                'description' => 'Apple iPhone 14 with A15 Bionic chip, 6.1-inch Super Retina XDR display, dual-camera system, and emergency SOS via satellite. Experience premium performance.',
                'price'       => 115000.00,
                'stock'       => 10,
                'image'       => null,
            ],
            [
                'name'        => 'Dell Inspiron 15 Laptop',
                'description' => 'Dell Inspiron 15 with Intel Core i5 12th Gen processor, 8GB RAM, 512GB SSD, and 15.6-inch FHD display. Perfect for students and professionals.',
                'price'       => 75000.00,
                'stock'       => 15,
                'image'       => null,
            ],
            [
                'name'        => 'Sony WH-1000XM5 Headphones',
                'description' => 'Industry-leading noise cancellation headphones with 30-hour battery life, multipoint connection, and crystal-clear call quality. Premium audio experience.',
                'price'       => 35000.00,
                'stock'       => 30,
                'image'       => null,
            ],
            [
                'name'        => 'Nike Air Max 270',
                'description' => 'Nike Air Max 270 running shoes featuring the largest Air unit yet for maximum cushioning and comfort. Lightweight and stylish for everyday wear.',
                'price'       => 12000.00,
                'stock'       => 50,
                'image'       => null,
            ],
            [
                'name'        => 'Canon EOS M50 Camera',
                'description' => 'Canon EOS M50 Mark II mirrorless camera with 24.1MP sensor, 4K video recording, Eye Detection AF, and built-in Wi-Fi. Great for content creators.',
                'price'       => 65000.00,
                'stock'       => 3, // low stock demo
                'image'       => null,
            ],
            [
                'name'        => 'Organic Cotton T-Shirt',
                'description' => 'Premium quality organic cotton t-shirt available in multiple colors. Soft, breathable, and eco-friendly fabric. Perfect for casual daily wear.',
                'price'       => 800.00,
                'stock'       => 100,
                'image'       => null,
            ],
            [
                'name'        => 'Stainless Steel Water Bottle',
                'description' => 'BPA-free stainless steel insulated water bottle that keeps drinks cold for 24 hours and hot for 12 hours. Leak-proof and eco-friendly.',
                'price'       => 1500.00,
                'stock'       => 0, // out of stock demo
                'image'       => null,
            ],
        ];

        foreach ($products as $data) {
            Product::firstOrCreate(
                ['name' => $data['name']],
                $data
            );
        }

        $this->command->info('8 sample products seeded successfully!');
    }
}
