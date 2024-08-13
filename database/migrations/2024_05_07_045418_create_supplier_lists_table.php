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
        Schema::create('supplier_lists', function (Blueprint $table) {
            $table->id('supplier_id')->autoIncrement();
            $table->integer('supplier_code')->default(0);
            $table->integer('no');
            $table->string('supplier');
            $table->integer('telephone');
            $table->string('contact');
            $table->string('address');
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
        Schema::dropIfExists('supplier_lists');
    }
};
