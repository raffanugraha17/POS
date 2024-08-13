<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log; // Import Log class

class CashierList extends Model
{
    use SoftDeletes;

    protected $primaryKey = "cashier_id";
    protected $fillable = ['cashier_code','cashier_name','cashier_telephone','cashier_role','cashier_shift','cashier_gender','flag'];

    protected $casts = [
        'flag' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($cashierList) {
            $cashierList->flag = true;
            $cashierList->save();
        });

        static::created(function ($cashierList) {
            Log::channel('activitylog')->info('Setting & configurations/ Cashier List created', ['id' => $cashierList->id]);
        });

        static::updated(function ($cashierList) {
            Log::channel('activitylog')->info('Setting & configurations/ Cashier List updated', ['id' => $cashierList->id]);
        });

        static::deleted(function ($cashierList) {
            Log::channel('activitylog')->info('Setting & configurations/ Cashier List deleted', ['id' => $cashierList->id]);
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
