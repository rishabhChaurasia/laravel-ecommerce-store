# LaraStore: Comprehensive Project Plan & Architecture

**Project Name:** LaraStore
**Goal:** Build a robust, scalable e-commerce application using Laravel 11.
**Complexity Level:** Intermediate/Advanced
**Date:** November 22, 2025

---

## 1. Technical Stack & Requirements

### Core Frameworks
*   **Backend:** Laravel 11.x
*   **Frontend:** Blade Templates (Server-Side Rendering)
*   **Styling:** Tailwind CSS (Utility-first framework)
*   **Interactivity:** Alpine.js (Lightweight JS for dropdowns, modals, cart toggles)
*   **Database:** MySQL 8.0+ or PostgreSQL

### Key Libraries
*   **Authentication:** Laravel Breeze (Simple) or Jetstream (Advanced)
*   **Payments:** Laravel Cashier (Stripe)
*   **Media:** Spatie Media Library (optional) or standard Laravel Storage
*   **Debugging:** Laravel Telescope (for local development)

---

## 2. Database Architecture (Schema)

### A. Users & Roles
*   **`users`**:
    *   `id`, `name`, `email`, `password`
    *   `role`: `enum('admin', 'customer')` (default: 'customer')
    *   `addresses`: JSON or separate table for shipping info.

### B. Product Catalog
*   **`categories`**:
    *   `id`, `name`, `slug` (unique), `image_path`, `is_active`
    *   *Self-referencing parent_id for nested categories (optional).*
*   **`products`**:
    *   `id`, `category_id` (FK), `name`, `slug`, `description` (text)
    *   `price`: `unsignedInteger` (Store in cents to avoid floating point errors)
    *   `sale_price`: `unsignedInteger` (nullable)
    *   `stock_quantity`: `integer`
    *   `sku`: `string` (unique)
    *   `is_active`: `boolean`

### C. Shopping & Orders
*   **`orders`**:
    *   `id`, `user_id` (FK, nullable for guest checkout)
    *   `status`: `enum('pending', 'processing', 'shipped', 'delivered', 'cancelled')`
    *   `payment_status`: `enum('unpaid', 'paid', 'refunded')`
    *   `payment_method`: `string` (e.g., 'stripe', 'cod')
    *   `grand_total`: `unsignedInteger`
    *   `shipping_address`: `json` (Snapshot of address at time of order)
*   **`order_items`**:
    *   `id`, `order_id` (FK)
    *   `product_id` (FK)
    *   `quantity`: `integer`
    *   `unit_price`: `unsignedInteger` (Snapshot of price at time of purchase - CRITICAL)

### D. User Personalization
*   **`wishlists`**:
    *   `id`, `user_id` (FK)
    *   `product_id` (FK)
    *   `created_at` (For "Added on" date)

### E. Cart & Checkout (Persistent)
*   **`carts`**: `id`, `user_id` (nullable), `session_id` (string, index), `expires_at`
*   **`cart_items`**: `id`, `cart_id`, `product_id`, `quantity`
*   **`reviews`**:
    *   `id`, `user_id`, `product_id`, `rating` (1-5), `comment`, `is_approved` (boolean)

### F. Performance Optimization
*   **`indexes`**:
    *   `products`: `slug`, `category_id`
    *   `orders`: `user_id`, `order_number`
    *   `users`: `email`

---

## 3. Module Breakdown

### Module 1: Admin Panel
**Route Prefix:** `/admin`
**Middleware:** `auth`, `admin`
*   **Dashboard:** Show total sales, recent orders, low stock alerts.
*   **Product Management:**
    *   CRUD for Products and Categories.
    *   Image Upload handling (store in `public/storage`).
*   **Order Management:**
    *   View order details.
    *   Update Order Status (e.g., change 'Processing' to 'Shipped').
*   **User Management:**
    *   View all registered users.
    *   View user order history.
    *   Ban/Suspend users.
*   **Marketing & Analytics:**
    *   **Coupons:** Create discount codes (Fixed amount or %).
    *   **Reports:** Sales charts (Daily/Monthly revenue), Top selling products.

### Module 2: Public Storefront
**Route Prefix:** `/`
*   **Home:** Hero section, Featured Categories, New Arrivals.
*   **Shop/Listing:**
    *   Sidebar filters: Price Range, Categories.
    *   Sorting: Price (Low-High), Newest.
    *   Pagination (12 items per page).
    *   **Wishlist Toggle:** Heart icon on product cards (AJAX).
*   **Product Detail:**
    *   Image Gallery.
    *   "Add to Cart" button.
    *   "Add to Wishlist" button.
    *   **Product Reviews:** User ratings and comments section.
    *   Related Products (Same category).
*   **User Account:**
    *   Order History.
    *   My Wishlist Page.

### Module 3: Shopping Cart & System Logic
*   **Storage Strategy:**
    *   **Guest:** Store cart in `Session` or `Cookies`.
    *   **User:** Store cart in Database (`carts` table).
    *   **Merge:** On Login, merge Session cart into Database cart.
*   **Features:**
    *   Update Quantity (AJAX/Alpine.js recommended).
    *   Remove Item.
    *   Real-time total calculation.
    *   **Stock Reservation:** Temporarily hold stock for 15 mins during checkout.

### Module 4: Checkout & Payment
*   **Step 1:** Guest Login / Register (Optional).
*   **Step 2:** Shipping Information Form.
*   **Step 3:** Payment (Stripe Integration).
*   **Step 4:** Order Finalization.
    *   **DB Transaction:**
        1.  Create Order Record.
        2.  Create Order Items.
        3.  Decrement Product Stock.
        4.  Clear Cart.
        5.  **Notifications:**
            *   Send "Order Received" Email to Customer (Queue).
            *   Send "New Order" Notification to Admin (Database/Email).

---

## 4. Development Roadmap (14-Day Plan)

### Phase 1: Foundation & Schema (Days 1-2)
1.  `laravel new lara-store` & Database Config.
2.  **Schema & Migrations:** Create tables including `carts`, `reviews` and add Indexes.
3.  **Models & Relations:** Define `hasMany`, `belongsTo` relationships.
4.  **Validation Rules:** specific FormRequests for `StoreProductRequest`, `CheckoutRequest`.

### Phase 2: The Admin Core (Days 3-5)
1.  **Authentication:** Install Breeze/Jetstream.
2.  **Admin Middleware** & Dashboard.
3.  **Product Management:** CRUD with Image Upload (Spatie Media Library or native).
4.  **Stock Management:** Basic inventory logic.

### Phase 3: The Storefront & Engagement (Days 6-9)
1.  **Layouts:** Main Shop UI (Grid/List).
2.  **Product Details:** Show description, images, and **Reviews**.
3.  **Cart System:** Implement persistent cart (DB + Session) and Merge logic.
4.  **Wishlist:** Toggle functionality.

### Phase 4: Checkout & Logic (Days 10-12)
1.  **Checkout Flow:** Address Form -> Payment -> Summary.
2.  **Order Logic:** Database Transactions & Stock Reservation.
3.  **Background Jobs:**
    *   Setup Queue Worker (`database` or `redis`).
    *   Create `OrderConfirmation` Email.
    *   Create `AbandonedCart` Job (Draft).

### Phase 5: Reliability & Polish (Days 13-14)
1.  **Testing Strategy:**
    *   Write Feature Test: `UserCanCheckoutTest`.
    *   Write Unit Test: `CartCalculationTest`.
2.  **Admin Notifications:** Ensure admins get alerted on new orders.
3.  **Final Review:** Run `php artisan optimize`, check security headers.

---

## 5. Directory Structure Best Practices
Suggestion for organizing your logic:

```
app/
  Services/
    CartService.php       # Handles cart session logic
    OrderService.php      # Handles order creation & stock deduction
    PaymentService.php    # Wraps Stripe logic
  Models/
    Product.php
    Order.php
  Http/
    Controllers/
      Admin/
        ProductController.php
      Shop/
        CartController.php
        CheckoutController.php
```
