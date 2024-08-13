<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log; // Import Log class

class Category extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    protected $fillable = [ 'name', 'flag'];

    protected $casts = [
        'flag' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            $category->flag = true;
            $category->save();
        });

        static::created(function ($category) {
            Log::channel('activitylog')->info('Category created', ['id' => $category->id]);
        });

        static::updated(function ($category) {
            Log::channel('activitylog')->info('Category updated', ['id' => $category->id]);
        });

        static::deleted(function ($category) {
            Log::channel('activitylog')->info('Category deleted', ['id' => $category->id]);
        });
    }

    public static function logCrudOperation($activity, $model)
    {
        $userId = auth()->id();
        $modelName = get_class($model);
        $tableName = $model->getTable();

        // Implement logic to log CRUD operations if needed
    }

 // Category.php
public function subCategories()
{
    return $this->hasMany(SubCategory::class);
}
}
