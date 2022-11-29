<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageChickenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_chicken', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('package');
            $table->foreignId('chicken_menu_id')->constrained('chicken_menu');
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
        Schema::table('package_chicken', function(Blueprint $table) {
            $table->dropForeign('package_chicken_package_id_foreign');
            $table->dropForeign('package_chicken_chicken_menu_id_foreign');
        });
        Schema::dropIfExists('package_chicken');
    }
}
