<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageRiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_rice', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('package');
            $table->foreignId('rice_menu_id')->constrained('rice_menu');
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
        Schema::table('package_rice', function(Blueprint $table) {
            $table->dropForeign('package_rice_package_id_foreign');
            $table->dropForeign('package_rice_rice_menu_id_foreign');
        });
        Schema::dropIfExists('package_rice');
    }
}
