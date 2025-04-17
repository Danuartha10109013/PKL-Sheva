<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('post', function (Blueprint $table) {
            $table->id(); // bigint unsigned auto-increment
            $table->string('user_id');
            $table->string('forum_id');
            $table->string('file')->nullable();
            $table->string('judul')->nullable();
            $table->string('desc')->nullable();
            $table->timestamp('created_at')->nullable()->default(null);
            $table->timestamp('updated_at')->nullable()->default(null);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post');
    }
};
