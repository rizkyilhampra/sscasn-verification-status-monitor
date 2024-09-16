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
        Schema::table('user_request_headers', function (Blueprint $table) {
            $table->string('result')
                ->nullable()
                ->after('x_xsrf_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_request_headers', function (Blueprint $table) {
            $table->dropColumn('result');
        });
    }
};
