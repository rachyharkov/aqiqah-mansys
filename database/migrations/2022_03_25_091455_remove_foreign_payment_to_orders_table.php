<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveForeignPaymentToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // drop column
            $table->dropForeign('orders_payment_id_foreign');
            $table->dropColumn('payment_id');
        });

        Schema::table('orders', function(Blueprint $table) {
            $table->integer('payment_id')->nullable();
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
            $table->dropColumn('payment_id');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('payment_id')->constrained('payment');
        });
    }
}
