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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id'); // Foreign key to the sellers table
            $table->string('bank_acc_name'); // Bank account name
            $table->string('bank_acc_number'); // Bank account number
            $table->string('bank_type'); // Bank type (e.g., CIMB, Maybank)
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
