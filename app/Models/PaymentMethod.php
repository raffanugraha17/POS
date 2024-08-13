<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class PaymentMethod extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'payment_method_id';
    protected $fillable = ['payment_method_code','payment_method','flag'];
    protected $casts = [
        'flag' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($paymentMethod) {
            $paymentMethod->flag = true;
            $paymentMethod->save();
        });
        static::created(function ($paymentMethod) {
            Log::channel('activitylog')->info('Setting & configurations/ Payment Method created', ['id' => $paymentMethod->id]);
        });

        static::updated(function ($paymentMethod) {
            Log::channel('activitylog')->info('Setting & configurations/ Payment Method updated', ['id' => $paymentMethod->id]);
        });

        static::deleted(function ($paymentMethod) {
            Log::channel('activitylog')->info('Setting & configurations/ Payment Method deleted', ['id' => $paymentMethod->id]);
        });
    }

    public static function logCrudOperation($activity, $model)
    {
        $userId = auth()->id();
        $modelName = get_class($model);
        $tableName = $model->getTable();

        // Implementasi untuk menyimpan log
        // Pastikan metode ini sesuai dengan struktur dan kebutuhan Anda
    }
}
    

