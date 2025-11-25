<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'), // Add a default password for easy testing
        ]);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $categories = [
            'Electronics & Gadgets',
            'Fashion & Apparel',
            'Home & Kitchen',
            'Beauty & Personal Care',
            'Health & Fitness',
            'Sports & Outdoor',
            'Automotive Accessories',
            'Toys & Games',
            'Books & Stationery',
            'Pet Supplies',
            'Furniture & Home Decor',
            'Grocery & Essentials',
            'Baby & Kids',
            'Tools & Hardware',
            'Computers & Accessories',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
                'is_active' => true,
            ]);
        }

        $products = [
            ['category' => 'Electronics & Gadgets', 'product_name' => 'Aurora Wireless Noise-Canceling Headphones', 'price_in_cents' => 19999, 'sale_price_in_cents' => 14999, 'stock_quantity' => 42, 'desc' => 'Over-ear Bluetooth headphones with active noise cancellation, 30-hour battery life, and fast charge.'],
            ['category' => 'Fashion & Apparel', 'product_name' => 'Everday Stretch Organic Tee (Unisex)', 'price_in_cents' => 2499, 'sale_price_in_cents' => 1999, 'stock_quantity' => 150, 'desc' => 'Soft organic-cotton tee with four-way stretch — breathable, durable, and eco-friendly.'],
            ['category' => 'Home & Kitchen', 'product_name' => 'Nora Ceramic Chef\'s Knife 8"', 'price_in_cents' => 4599, 'sale_price_in_cents' => 3999, 'stock_quantity' => 67, 'desc' => 'High-hardness ceramic blade for long-lasting sharpness; ergonomic handle for precise control.'],
            ['category' => 'Beauty & Personal Care', 'product_name' => 'GlowMist Hydrating Facial Serum 30ml', 'price_in_cents' => 2999, 'sale_price_in_cents' => 2499, 'stock_quantity' => 120, 'desc' => 'Lightweight serum with hyaluronic acid and vitamin B5 to hydrate and plump skin.'],
            ['category' => 'Health & Fitness', 'product_name' => 'StridePro Smart Running Band', 'price_in_cents' => 8999, 'sale_price_in_cents' => 8999, 'stock_quantity' => 88, 'desc' => 'Activity band with GPS, heart-rate monitoring, and real-time coaching. Water resistant.'],
            ['category' => 'Sports & Outdoor', 'product_name' => 'RidgeLine 2-Person Ultralight Tent', 'price_in_cents' => 12999, 'sale_price_in_cents' => 9999, 'stock_quantity' => 34, 'desc' => 'Compact, weatherproof backpacking tent — fast pitch, breathable mesh, low weight.'],
            ['category' => 'Automotive Accessories', 'product_name' => 'FluxCharge USB-C Car Charger (45W)', 'price_in_cents' => 2199, 'sale_price_in_cents' => 1799, 'stock_quantity' => 210, 'desc' => 'Dual-port USB-C car charger with fast-charge PD support and built-in surge protection.'],
            ['category' => 'Toys & Games', 'product_name' => 'BuildBot STEM Robotics Kit', 'price_in_cents' => 5499, 'sale_price_in_cents' => 4499, 'stock_quantity' => 56, 'desc' => 'Hands-on robotics kit for ages 8+, programmable via block-based code; includes sensors and motor.'],
            ['category' => 'Books & Stationery', 'product_name' => 'Pocket Planner — Daily Minimalist (2026)', 'price_in_cents' => 1299, 'sale_price_in_cents' => 999, 'stock_quantity' => 320, 'desc' => 'Compact daily planner with time blocks, habit tracker, and notes — hardcover, lay-flat binding.'],
            ['category' => 'Pet Supplies', 'product_name' => 'Pawsitive Indoor Activity Mat (Small)', 'price_in_cents' => 3499, 'sale_price_in_cents' => 2999, 'stock_quantity' => 95, 'desc' => 'Interactive mealtime mat for dogs and cats — slows eating and provides mental stimulation.'],
        ];

        foreach ($products as $product) {
            $category = Category::where('name', $product['category'])->first();
            Product::create([
                'category_id' => $category->id,
                'name' => $product['product_name'],
                'slug' => Str::slug($product['product_name']),
                'description' => $product['desc'],
                'price' => $product['price_in_cents'],
                'sale_price' => $product['sale_price_in_cents'],
                'stock_quantity' => $product['stock_quantity'],
                'sku' => strtoupper(Str::random(8)),
                'is_active' => true,
                'image_path' => null,
            ]);
        }
    }
}
