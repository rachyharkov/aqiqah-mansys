<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterNullableToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('name_of_aqiqah');
            $table->dropColumn('gender_of_aqiqah');
            $table->dropColumn('birth_of_date');
            $table->dropColumn('father_name');
            $table->dropColumn('mother_name');
            $table->dropColumn('address');
        });

        Schema::table('customers', function(Blueprint $table) {
            $table->string('name_of_aqiqah')->nullable();
            $table->string('gender_of_aqiqah')->nullable();
            $table->timestamp('birth_of_date')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->text('address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('name_of_aqiqah');
            $table->dropColumn('gender_of_aqiqah');
            $table->dropColumn('birth_of_date');
            $table->dropColumn('father_name');
            $table->dropColumn('mother_name');
            $table->dropColumn('address');
        });

        Schema::table('customers', function(Blueprint $table) {
            $table->string('name_of_aqiqah');
            $table->string('gender_of_aqiqah');
            $table->timestamp('birth_of_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('father_name');
            $table->string('mother_name');
            $table->text('address');
        });
    }
}
