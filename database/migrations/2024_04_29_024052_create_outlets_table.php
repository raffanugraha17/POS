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
        Schema::create('outlets', function (Blueprint $table) {
            $table->bigIncrements('outlet_id');
            $table->bigInteger('outlet_code')->default(0);
            $table->binary('outlet_logo'); 
            $table->string('outlet_name');
            $table->text('outlet_telephone');
            $table->string('outlet_address');
            $table->boolean('flag')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outlets');
    }
};