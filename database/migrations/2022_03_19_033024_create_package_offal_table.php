<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageOffalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_offal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('package');
            $table->foreignId('offal_menu_id')->constrained('offal_menu');
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
        Schema::table('package_offal', function(Blueprint $table) {
            $table->dropForeign('package_offal_package_id_foreign');
            $table->dropForeign('package_offal_offal_menu_id_foreign');
        });
        Schema::dropIfExists('package_offal');
    }
}
