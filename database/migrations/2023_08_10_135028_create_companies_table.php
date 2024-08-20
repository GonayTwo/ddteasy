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
        Schema::create('companies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('fantasy_name')->unique();
            $table->string('corporate_name')->unique();
            $table->string('cnpj', 14)->unique();
            $table->string('social_contract');
            $table->string('sanitary_license');
            $table->string('logo')->nullable();
            $table->boolean('approved')->default(false);
            $table->string('slug')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
