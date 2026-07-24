<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->string('idbooking');
            $table->string('nomor_invoice')->unique();
            $table->string('jenis');
            $table->decimal('nominal', 15, 2);
            $table->string('status')->default('Unpaid');
            $table->timestamps();
            $table->foreign('idbooking')
                ->references('idbooking')
                ->on('booking')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
