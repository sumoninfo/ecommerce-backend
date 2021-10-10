<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryStatusHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->index()->comment("Delivery")->nullable()->constrained('deliveries')->onDelete('cascade');
            $table->date('approved')->nullable();
            $table->date('processing')->nullable();
            $table->date('shipped')->nullable();
            $table->date('delivered')->nullable();
            $table->date('rejected')->nullable();
            $table->foreignId('created_by')->index()->comment("Created by")->nullable()->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('delivery_status_histories');
    }
}
