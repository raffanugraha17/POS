<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log; // Import Log class

class SubCategory extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    protected $fillable = [ 'name','category_id','flag'];

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

        static::created(function ($subCategory) {
            Log::channel('activitylog')->info('Sub Category created', ['id' => $subCategory->id]);
        });

        static::updated(function ($subCategory) {
            Log::channel('activitylog')->info('Sub Category updated', ['id' => $subCategory->id]);
        });

        static::deleted(function ($subCategory) {
            Log::channel('activitylog')->info('Sub Category deleted', ['id' => $subCategory->id]);
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
}

