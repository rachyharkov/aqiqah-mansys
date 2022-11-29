<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNullableToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // drop column first
            $table->dropColumn('number_of_goats');
            $table->dropColumn('gender_of_goats');
            $table->dropForeign('orders_type_order_id_foreign');
            $table->dropColumn('type_order_id');
            $table->dropColumn('qty');
            $table->dropForeign('orders_shipping_id_foreign');
            $table->dropColumn('shipping_id');
            $table->dropColumn('total');
            $table->dropColumn('consumsion_time');
            $table->dropColumn('branch_group_id');
        });

        // create new format
        Schema::table('orders', function(Blueprint $table) {
            $table->integer('number_of_goats')->nullable();
            $table->integer('gender_of_goats')->nullable();
            $table->integer('type_order_id')->nullable();
            $table->integer('qty')->default(0);
            $table->integer('shipping_id')->nullable();
            $table->integer('total')->default(0);
            $table->string('consumsion_time')->nullable();
            $table->integer('branch_group_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('number_of_goats');
            $table->dropColumn('gender_of_goats');
            $table->dropColumn('type_order_id');
            $table->dropColumn('qty');
            $table->dropColumn('shipping_id');
            $table->dropColumn('total');
            $table->dropColumn('consumsion_time');
            $table->dropColumn('branch_group_id');
        });

        Schema::table('orders', function(Blueprint $table) {
            $table->integer('number_of_goats');
            $table->integer('gender_of_goats');
            $table->foreignId('type_order_id')->constrained('type_order');
            $table->integer('qty');
            $table->foreignId('shipping_id')->constrained('shipping');
            $table->integer('total');
            $table->string('consumsion_time');
            $table->integer('branch_group_id');
        });
    }
}
