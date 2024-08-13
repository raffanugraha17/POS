<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log; // Import Log class

class Shift extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'shift_id';
    protected $fillable = ['shift_code', 'shift_name', 'start_shift', 'end_shift', 'flag'];

    protected $casts = [
        'flag' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($shift) {
            $shift->flag = true;
            $shift->save();
        });

        static::created(function ($shift) {
            Log::channel('activitylog')->info('Setting & configurations/ Shift created', ['id' => $shift->id]);
        });

        static::updated(function ($shift) {
            Log::channel('activitylog')->info('Setting & configurations/ Shift updated', ['id' => $shift->id]);
        });

        static::deleted(function ($shift) {
            Log::channel('activitylog')->info('Setting & configurations/ Shift deleted', ['id' => $shift->id]);
        });
    }

    public static function logCrudOperation($activity, $model)
    {
        $userId = auth()->id();
        $modelName = get_class($model);
        $tableName = $model->getTable();

        // Implement logic to log CRUD operations if needed
    }
}
