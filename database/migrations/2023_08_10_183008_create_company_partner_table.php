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
        Schema::create('company_partner', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('company_id')->references('id')->on('companies');
            $table->foreignUuid('partner_id')->references('id')->on('partners');
            $table->boolean('responsible')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_partner');
    }
};
