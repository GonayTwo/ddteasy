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
        Schema::create('customers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('pagarme_id')->nullable();
            $table->date('birth_date');
            $table->string('cpf', 11)->unique();
            $table->string('phone', 14)->unique();
            $table->json('contact_methods');
            $table->boolean('consent');
            $table->boolean('newsletter')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
