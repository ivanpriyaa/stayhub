<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->string('idbooking')->primary();
            $table->string('idvilla');
            $table->string('idcustomer');
            $table->date('tglbooking');
            $table->string('pic');
            $table->dateTime('tglcekin');
            $table->dateTime('tglcekout');
            $table->string('note');
            $table->integer('harga')->unsigned();
            $table->integer('total_harga')->unsigned();
            $table->string('nama_agen')->nullable();
            $table->timestamps();
            $table->foreign('idvilla')->references('idvilla')->on('villa');
            $table->foreign('idcustomer')->references('idcustomer')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
