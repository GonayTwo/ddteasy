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
        Schema::create('company_service', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('company_id')->references('id')->on('companies');
            $table->foreignUuid('service_id')->references('id')->on('services');
            $table->integer('daily_price');
            $table->string('property_type');
            $table->string('property_size');
            $table->timestamps();

            $table->unique(['company_id', 'service_id', 'property_type', 'property_size'], 'company_service_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_service');
    }
};
