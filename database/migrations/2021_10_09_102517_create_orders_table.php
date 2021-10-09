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
            $table->foreignId('user_id')->index()->comment("Customer")->constrained()->onDelete('cascade');
            $table->string("customer_email")->nullable();
            $table->text('shipping_address')->nullable();
            $table->float("sub_total", 22, 4)->default(0);
            $table->integer("total_quantity")->default(0);
            $table->float("discount", 5, 2)->default(0);
            $table->float("shipping_cost", 5, 2)->default(0);
            $table->float("grand_total", 22, 4)->index()->default(0);
            $table->text("note")->nullable();
            $table->enum('status', ['Approved', 'Rejected', 'Processing', 'Shipped', 'Delivered', 'Pending'])->default('Pending');
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
        Schema::dropIfExists('orders');
    }
}
