<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->comment("Customer")->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->index()->comment("Room")->constrained()->cascadeOnDelete();
            $table->string("booking_no")->nullable();
            $table->date("date")->nullable();
            $table->dateTime("check_in")->nullable();
            $table->dateTime("check_out")->nullable();
            $table->string("customer_email")->nullable();
            $table->string("customer_number")->nullable();
            $table->text('address')->nullable();
            $table->float("sub_total", 22, 4)->default(0);
            $table->float("discount", 5, 2)->default(0);
            $table->float("grand_total", 22, 4)->index()->default(0);
            $table->text("note")->nullable();
            $table->enum('status', ['Approved', 'Rejected', 'Pending'])->default('Pending');
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
        Schema::dropIfExists('bookings');
    }
}
