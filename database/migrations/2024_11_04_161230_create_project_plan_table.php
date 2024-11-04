<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_plan', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('project_id'); 
            $table->text('pengantar')->nullable();
            $table->text('ringkasan')->nullable();
            $table->text('ruang_lingkup')->nullable();
            $table->text('jadwal_proyek')->nullable();
            $table->text('fase_1')->nullable();
            $table->text('team_proyek')->nullable();
            $table->text('manajemen_proyek')->nullable();
            $table->text('fitur_utama')->nullable();
            $table->text('rincian_teknis')->nullable();
            $table->text('topologi')->nullable();
            $table->text('diagram')->nullable();
            $table->text('anggaran', 15, 2)->nullable(); // Example for budget
            $table->text('pernyataan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_plan');
    }
}
