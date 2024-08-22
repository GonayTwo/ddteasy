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
        Schema::create('addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuidMorphs('addressable');
            $table->string('name')->nullable();
            $table->string('cep', 8);
            $table->string('street');
            $table->string('number', 20);
            $table->string('complement')->nullable();
            $table->string('district');
            $table->string('city');
            $table->string('state', 2);
            $table->string('country');
            $table->double('lat')->nullable();
            $table->double('lon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
