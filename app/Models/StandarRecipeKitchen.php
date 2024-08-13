<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandarRecipeKitchen extends Model
{
    use HasFactory;
    protected $table = [ 'menu_id','raw_material_id','unit_id','volume_id','flag'];

    // public function menu()
    // {
    //     return $this->belongsToMany(Menu::class);
    // }
    // public function rawMaterialList()
    // {
    //     return $this->belongsToMany(RawMaterialList::class);
    // }

}
