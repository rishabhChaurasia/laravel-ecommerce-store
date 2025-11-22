<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('type', ['fixed', 'percentage']);
            $table->decimal('value', 10, 2); // Fixed amount or percentage
            $table->decimal('min_amount', 10, 2)->nullable(); // Minimum order amount
            $table->integer('usage_limit')->nullable(); // Max number of times coupon can be used
            $table->integer('usage_count')->default(0); // Current usage count
            $table->timestamp('expires_at')->nullable(); // Expiry date
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
