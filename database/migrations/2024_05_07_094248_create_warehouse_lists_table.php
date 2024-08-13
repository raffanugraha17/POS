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
        Schema::create('warehouse_lists', function (Blueprint $table) {
            $table->id('warehouse_id')->autoIncrement();
            $table->integer('warehouse_code')->default(0);
            $table->string('warehouse');
            $table->string('type');
            $table->string('location');
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
        Schema::dropIfExists('warehouse_lists');
    }
};
