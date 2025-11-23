<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Cartitem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_checkout()
    {
        // Create a user
        $user = User::factory()->create();
        
        // Create a product
        $product = Product::factory()->create([
            'price' => 1000, // $10.00 in cents
            'stock_quantity' => 5,
        ]);
        
        // Authenticate the user
        $this->actingAs($user);
        
        // Add product to user's cart
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
        
        // Test checkout flow
        // Step 1: Access checkout review page
        $response = $this->get(route('checkout.index'));
        $response->assertStatus(200);
        
        // Step 2: Fill shipping information
        $response = $this->post(route('checkout.store.shipping'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'address' => '123 Main St',
            'city' => 'Anytown',
            'state' => 'CA',
            'zipcode' => '12345',
            'country' => 'USA',
        ]);
        $response->assertRedirect(route('checkout.payment'));
        
        // Step 3: Process payment
        $response = $this->post(route('checkout.process.payment'), [
            'payment_method' => 'cod',
        ]);
        
        // Should redirect to success page
        $response->assertRedirect();
        $this->assertStringContainsString('checkout/success', $response->headers->get('Location'));
        
        // Verify order was created
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'payment_method' => 'cod',
            'status' => 'pending', // COD orders start as pending
        ]);
        
        // Verify order items were created
        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
        
        // Verify stock was reduced
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock_quantity' => 3, // Started with 5, 2 purchased
        ]);
    }

    public function test_guest_user_cannot_access_checkout()
    {
        $response = $this->get(route('checkout.index'));
        
        // Should redirect to login
        $response->assertRedirect(route('login'));
    }

    public function test_checkout_with_empty_cart_redirects()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $response = $this->get(route('checkout.index'));
        
        // Should redirect to cart with error
        $response->assertRedirect(route('cart.index'));
    }
}