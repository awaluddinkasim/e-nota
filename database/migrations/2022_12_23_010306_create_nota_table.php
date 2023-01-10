<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota', function (Blueprint $table) {
            $table->id();
            $table->string('nomor')->unique();
            $table->foreignId('toko_id');
            $table->foreignId('customer_id');
            $table->foreignId('gabah_id');
            $table->text('catatan')->nullable();
            $table->string('ttd');
            $table->timestamps();

            $table->foreign('toko_id')->references('id')->on('toko')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('gabah_id')->references('id')->on('gabah')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nota');
    }
};
