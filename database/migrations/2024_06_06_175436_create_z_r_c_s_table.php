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
        Schema::create('z_r_c_s', function (Blueprint $table) {
            $table->id();
            $table->string('RCID',2);
            $table->string('RCRTCD',5);
            $table->string('RCDESC',30);
            $table->string('RCEDTE',8);
            $table->string('RCCSET',1);
            $table->string('RCCTXR',20);
            $table->string('RCNTXR',20);
            $table->string('RCCTRA',20);
            $table->string('RCNTRA',20);
            $table->string('RCCTXP',20);
            $table->string('RCNTXP',20);
            $table->string('RCCTPA',20);
            $table->string('RCNTPA',20);
            $table->string('RCCRTE',8);
            $table->string('RCNRTE',8);
            $table->string('RCRNDM',1);
            $table->string('RCRNDP',1);
            $table->string('RCTAXN',1);
            $table->string('RCVATT',1);
            $table->string('RCVATN',1);
            $table->string('RCINPC',2);
            $table->string('RCINFL',1);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('z_r_c_s');
    }
};
