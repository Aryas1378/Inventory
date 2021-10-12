<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnsEmailVerifiedAtAndTwoFactorSecretAndTwoFactorRecoveryCodesInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email_verified_at');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('two_factor_secret');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('two_factor_recovery_codes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email_verified_at');
            $table->string('two_factor_secret');
            $table->string('two_factor_recovery_codes');
        });
    }
}
