<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('project', function (Blueprint $table) {
            $table->id(); // bigint unsigned auto-increment
            $table->string('judul');
            $table->string('pm_id');
            $table->string('customer_id');
            $table->integer('team_leader_id');
            $table->integer('launch')->default(0);
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->decimal('biaya', 30, 2)->nullable();
            $table->decimal('progres', 11, 2)->default(0.00);
            $table->timestamp('created_at')->nullable()->default(null);
            $table->timestamp('updated_at')->nullable()->default(null);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project');
    }
};
