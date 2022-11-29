<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('package_id')->constrained('package');
            $table->foreignId('payment_id')->constrained('payment');
            $table->foreignId('branch_id')->constrained('branch');
            $table->timestamp('send_date');
            $table->integer('number_of_goats');
            $table->string('gender_of_goats');
            $table->foreignId('type_order_id')->constrained('type_order');
            $table->boolean('maklon')->default(false);
            $table->text('notes')->nullable();
            $table->integer('qty');
            $table->foreignId('shipping_id')->constrained('shipping');
            $table->integer('additional_price')->default(0);
            $table->integer('discount_price')->default(0);
            $table->integer('total');
            $table->integer('created_by');
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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_customer_id_foreign');
            $table->dropForeign('orders_package_id_foreign');
            $table->dropForeign('orders_payment_id_foreign');
            $table->dropForeign('orders_branch_id_foreign');
            $table->dropForeign('orders_type_order_id_foreign');
            $table->dropForeign('orders_shipping_id_foreign');
        });
        Schema::dropIfExists('orders');
    }
}
