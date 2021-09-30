<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTechnicalManagerPermissionColumnToBorrowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('borrows', function (Blueprint $table) {
            $table->boolean('technical_manager_permission')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('borrows', function (Blueprint $table) {
            $table->dropColumn('technical_manager_permission');
        });
    }
}
