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
    Schema::create('history', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('project_id');
        $table->unsignedBigInteger('invoice');
        $table->string('no_invoice');
        $table->date('date');
        $table->string('kepada');
        $table->string('npwp')->nullable();
        $table->text('alamat')->nullable();
        $table->integer('no');
        $table->string('deskripsi');
        $table->string('unit');
        $table->decimal('harga', 15, 2);
        $table->decimal('jumlah', 15, 2);
        $table->decimal('ppn', 5, 2)->nullable();
        $table->decimal('subTotal', 15, 2);
        $table->decimal('total', 15, 2);
        $table->string('terbilang');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history');
    }
};
