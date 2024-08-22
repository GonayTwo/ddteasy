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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('bank')->after('slug')->nullable();
            $table->string('agency')->after('bank')->nullable();
            $table->string('checking_account')->after('agency')->nullable();

            $table->unique(['bank', 'agency', 'checking_account']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropIndex('companies_bank_agency_checking_account_unique');

            $table->dropColumn('bank');
            $table->dropColumn('agency');
            $table->dropColumn('checking_account');
        });
    }
};
