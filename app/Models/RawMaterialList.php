<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class RawMaterialList extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'raw_material_id';
    protected $fillable = ['raw_material_code','category','raw_material','type','package','unit_id','volume_id','price','flag'];
    protected $casts = [
        'flag' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($rawMaterialList) {
            $rawMaterialList->flag = true;
            $rawMaterialList->save();
        });
        static::created(function ($rawMaterialList) {
            Log::channel('activitylog')->info('Raw Material List Created', ['id' => $rawMaterialList->id]);
        });

        static::updated(function ($rawMaterialList) {
            Log::channel('activitylog')->info('Raw Material List updated', ['id' => $rawMaterialList->id]);
        });

        static::deleted(function ($rawMaterialList) {
            Log::channel('activitylog')->info('Raw Material List deleted', ['id' => $rawMaterialList->id]);
        });
    }

    public static function logCrudOperation($activity, $model)
    {
        $userId = auth()->id();
        $modelName = get_class($model);
        $tableName = $model->getTable();

      
    }

    // public function standarRecipeKitchen()
    // {
    //     return $this->belongsToMany(StandarRecipeKitchen::class);
    // }
}
    