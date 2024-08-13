<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRawMaterialListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raw_material_lists', function (Blueprint $table) {
            $table->id('raw_material_id')->autoIncrement();
            $table->integer('raw_material_code')->default(0);
            $table->string('raw_material');
            $table->enum('package', ['Cardboard', 'Bottle', 'Pack', 'Cup']);
            $table->enum('category', ['Wet', 'Dry']);
            $table->enum('type', ['Fruit', 'Leaf', 'Tubers', 'Flower', 'Legumes', 'Stemp']);
            $table->enum('unit', ['Kilogram', 'Grams', 'Pounds', 'Onces']);
            $table->enum('volume', ['Litre', 'Mililitre', 'Cubicalcentimeter']);
            $table->double('price', 15, 2);
            $table->boolean('flag')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('raw_material_lists');
    }
}