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
        Schema::create('z_r_t_s', function (Blueprint $table) {
            $table->id();
            $table->string('RTID',2);
            $table->string('RTCVCD',5);
            $table->string('RTICDE',5);
            $table->string('RTWHSE',5);
            $table->string('RTRC01',5);
            $table->string('RTRC02',5);
            $table->string('RTRC03',5);
            $table->string('RTRC04',5);
            $table->string('RTRC05',5);
            $table->string('RTRC06',5);
            $table->string('RTRC07',5);
            $table->string('RTRC08',5);
            $table->string('RTRC09',5);
            $table->string('RTRC10',5);
            $table->string('RTCF01',1);
            $table->string('RTCF02',1);
            $table->string('RTCF03',1);
            $table->string('RTCF04',1);
            $table->string('RTCF05',1);
            $table->string('RTCF06',1);
            $table->string('RTCF07',1);
            $table->string('RTCF08',1);
            $table->string('RTCF09',1);
            $table->string('RTCF10',1);
            $table->string('RTOTRC',1);            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('z_r_t_s');
    }
};
