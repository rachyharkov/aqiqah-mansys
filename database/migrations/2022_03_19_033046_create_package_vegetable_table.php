<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageVegetableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_vegetable', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('package');
            $table->foreignId('vegetable_menu_id')->constrained('vegetable_menu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_vegetable', function(Blueprint $table) {
            $table->dropForeign('package_vegetable_package_id_foreign');
            $table->dropForeign('package_vegetable_vegetable_menu_id_foreign');
        });
        Schema::dropIfExists('package_vegetable');
    }
}
