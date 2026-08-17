<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('logins', function (Blueprint $table) {
            $table->datetime('last_login_at')->nullable(); // Mencatat kapan terakhir login
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('logins', function (Blueprint $table) {
            $table->dropColumn('last_login_at');
        });
    }
};
