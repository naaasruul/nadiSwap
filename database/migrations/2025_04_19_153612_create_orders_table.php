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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->json('items'); // Store cart items as JSON
            $table->decimal('total', 10, 2);
            $table->string('delivery_status')->default('Pending'); // e.g., Pending, Completed
            $table->string('payment_status')->default('Pending'); // e.g., Pending, Completed
            $table->string('payment_method'); // e.g., Pending, Completed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
