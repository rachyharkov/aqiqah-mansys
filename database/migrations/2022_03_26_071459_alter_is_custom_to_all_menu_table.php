<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterIsCustomToAllMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // meat menu
        Schema::table('meat_menu', function (Blueprint $table) {
            $table->boolean('is_custom')->nullable()->default(false);
        });
        // offal menu
        Schema::table('offal_menu', function (Blueprint $table) {
            $table->boolean('is_custom')->nullable()->default(false);
        });
        // egg menu
        Schema::table('egg_menu', function (Blueprint $table) {
            $table->boolean('is_custom')->nullable()->default(false);
        });
        // chicken menu
        Schema::table('chicken_menu', function (Blueprint $table) {
            $table->boolean('is_custom')->nullable()->default(false);
        });
        // vegetable menu
        Schema::table('vegetable_menu', function (Blueprint $table) {
            $table->boolean('is_custom')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meat_menu', function (Blueprint $table) {
            $table->dropColumn('is_custom');
        });
        Schema::table('offal_menu', function (Blueprint $table) {
            $table->dropColumn('is_custom');
        });
        Schema::table('egg_menu', function (Blueprint $table) {
            $table->dropColumn('is_custom');
        });
        Schema::table('chicken_menu', function (Blueprint $table) {
            $table->dropColumn('is_custom');
        });
        Schema::table('vegetable_menu', function (Blueprint $table) {
            $table->dropColumn('is_custom');
        });
    }
}
