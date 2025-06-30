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
        Schema::create('rents', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->string('house_type');
            $table->decimal('rent', 8, 2);
            $table->decimal('deposit', 8, 2)->nullable();
            $table->text('facilities')->nullable();
            $table->string('preferred_gender')->nullable();
            $table->text('other_preferences')->nullable();
            $table->json('images')->nullable();
            $table->json('other_payments')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rents');
    }
};
