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
        Schema::create('nota_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId("nota_id");
            $table->integer("jumlah");
            $table->integer("berat");
            $table->integer("harga");
            $table->timestamps();

            $table->foreign('nota_id')->references('id')->on('nota')
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
        Schema::dropIfExists('nota_items');
    }
};
