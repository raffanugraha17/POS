<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log; // Import Log class

class Menu extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id';
    protected $fillable = [ 'category_id','sub_category_id','menu_id','stock','price','flag'];
    protected $casts = [
        'flag' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($subCategory) {
            $subCategory->flag = true;
            $subCategory->save();
        });

        static::created(function ($menu) {
            Log::channel('activitylog')->info('Menu created', ['id' => $menu->id]);
        });

        static::updated(function ($menu) {
            Log::channel('activitylog')->info('Menu updated', ['id' => $menu->id]);
        });

        static::deleted(function ($menu) {
            Log::channel('activitylog')->info('Menu deleted', ['id' => $menu->id]);
        });
    }

    public static function logCrudOperation($activity, $model)
    {
        $userId = auth()->id();
        $modelName = get_class($model);
        $tableName = $model->getTable();

        // Implement logic to log CRUD operations if needed
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    // public function standarRecipeKitchen()
    // {
    //     return $this->belongsToMany(StandarRecipeKitchen::class);
    // }
}



