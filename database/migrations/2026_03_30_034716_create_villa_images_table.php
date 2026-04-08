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
        Schema::create('villa_images', function (Blueprint $table) {
            $table->id();
            $table->string('villa_id');
            $table->string('gambar');
            $table->timestamps();

            $table->foreign('villa_id')
                ->references('idvilla')
                ->on('villa')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('villa_images');
    }
};
