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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('toko_id');
            $table->string('nama');
            $table->text('alamat');
            $table->string('no_hp');
            $table->foreignId('registered_by');
            $table->timestamps();

            $table->foreign('toko_id')->references('id')->on('toko')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('registered_by')->references('id')->on('users')
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
        Schema::dropIfExists('customers');
    }
};
