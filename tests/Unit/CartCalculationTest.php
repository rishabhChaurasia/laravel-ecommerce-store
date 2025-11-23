<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartCalculationTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_total_calculation_with_single_item()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'price' => 1000, // $10.00 in cents
        ]);

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        $cartItem = $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $total = 0;
        foreach ($cart->items as $item) {
            $total += $item->product->price * $item->quantity;
        }

        $this->assertEquals(1000, $total);
    }

    public function test_cart_total_calculation_with_multiple_items()
    {
        $user = User::factory()->create();
        $product1 = Product::factory()->create([
            'price' => 1500, // $15.00 in cents
        ]);
        $product2 = Product::factory()->create([
            'price' => 2500, // $25.00 in cents
        ]);

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        $cart->items()->create([
            'product_id' => $product1->id,
            'quantity' => 2,
        ]);
        $cart->items()->create([
            'product_id' => $product2->id,
            'quantity' => 1,
        ]);

        $total = 0;
        foreach ($cart->items as $item) {
            $total += $item->product->price * $item->quantity;
        }

        // (1500 * 2) + (2500 * 1) = 3000 + 2500 = 5500
        $this->assertEquals(5500, $total);
    }

    public function test_cart_total_calculation_with_quantity_greater_than_one()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'price' => 1200, // $12.00 in cents
        ]);

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        $total = 0;
        foreach ($cart->items as $item) {
            $total += $item->product->price * $item->quantity;
        }

        // 1200 * 3 = 3600
        $this->assertEquals(3600, $total);
    }

    public function test_cart_item_total_calculation()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'price' => 1000, // $10.00 in cents
        ]);

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        $cartItem = $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => 5,
        ]);

        $itemTotal = $cartItem->product->price * $cartItem->quantity;

        $this->assertEquals(5000, $itemTotal); // 1000 * 5 = 5000
    }

    public function test_cart_count_calculation()
    {
        $user = User::factory()->create();
        $product1 = Product::factory()->create();
        $product2 = Product::factory()->create();

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        $cart->items()->create([
            'product_id' => $product1->id,
            'quantity' => 2,
        ]);
        $cart->items()->create([
            'product_id' => $product2->id,
            'quantity' => 3,
        ]);

        $cartCount = 0;
        foreach ($cart->items as $item) {
            $cartCount += $item->quantity;
        }

        $this->assertEquals(5, $cartCount); // 2 + 3 = 5
    }
}