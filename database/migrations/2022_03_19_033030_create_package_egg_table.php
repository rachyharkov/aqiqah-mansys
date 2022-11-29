<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageEggTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_egg', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('package');
            $table->foreignId('egg_menu_id')->constrained('egg_menu');
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
        Schema::table('package_egg', function(Blueprint $table) {
            $table->dropForeign('package_egg_package_id_foreign');
            $table->dropForeign('package_egg_egg_menu_id_foreign');
        });
        Schema::dropIfExists('package_egg');
    }
}
