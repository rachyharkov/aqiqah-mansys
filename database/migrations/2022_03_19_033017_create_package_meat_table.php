<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageMeatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_meat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('package');
            $table->foreignId('meat_menu_id')->constrained('meat_menu');
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
        Schema::table('package_meat', function(Blueprint $table) {
            $table->dropForeign('package_meat_package_id_foreign');
            $table->dropForeign('package_meat_meat_menu_id_foreign');
        });
        Schema::dropIfExists('package_meat');
    }
}
