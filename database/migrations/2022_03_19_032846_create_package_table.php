<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_meat')->default(false);
            $table->boolean('is_offal')->default(false);
            $table->boolean('is_egg')->default(false);
            $table->boolean('is_chicken')->default(false);
            $table->boolean('is_vegetable')->default(false);
            $table->boolean('is_rice')->default(false);
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
        Schema::dropIfExists('package');
    }
}
