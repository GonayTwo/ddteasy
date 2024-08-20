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
            $table->uuid('id')->primary();
            $table->string('pagarme_id');
            $table->foreignUuid('company_id')->references('id')->on('companies');
            $table->foreignUuid('customer_id')->references('id')->on('customers');
            $table->date('date');
            $table->tinyText('observation')->nullable();
            $table->string('payment_method');
            $table->json('items');
            $table->json('property');
            $table->json('period');
            $table->boolean('recomendations');
            $table->string('payment_status');
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
