<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->id(); // bigint unsigned and auto-increment
            $table->string('project_id');
            $table->string('no_invoice')->nullable();
            $table->decimal('ppn', 11, 2)->default(0.11);
            $table->string('kepada')->nullable();
            $table->string('npwp')->nullable();
            $table->string('alamat')->nullable();
            // $table->string('harga')->nullable();
            // $table->string('terbilang')->nullable();
            $table->string('pembuat')->nullable();
            $table->date('date')->nullable();
            $table->date('due_date')->nullable();
            $table->string('30')->nullable();
            $table->string('60')->nullable();
            $table->string('90')->nullable();
            $table->string('100')->nullable();
            $table->timestamp('created_at')->nullable()->default(null);
            $table->timestamp('updated_at')->nullable()->default(null);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice');
    }
};
