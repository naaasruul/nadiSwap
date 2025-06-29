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
        Schema::create('order_cancellations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('cancelled_by_user_id')->constrained('users')->onDelete('cascade');
            $table->string('cancellation_reason');
            $table->text('custom_cancellation_reason')->nullable();
            $table->text('additional_comments')->nullable();
            $table->enum('cancelled_by_role', ['buyer', 'seller', 'admin'])->default('buyer');
            $table->timestamp('cancelled_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_cancellations');
    }
};
