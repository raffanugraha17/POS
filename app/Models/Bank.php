<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log; // Pastikan Log facade diimpor

class Bank extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'bank_id';
    protected $fillable = ['bank_code', 'bank_name', 'bank_account', 'bank_branch', 'flag'];

    protected $casts = [
        'flag' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($bank) {
            $bank->flag = true;
            $bank->save();
        });

        static::created(function ($bank) {
            Log::channel('activitylog')->info('Setting & configurations/ Bank created', ['id' => $bank->id]);
        });

        static::updated(function ($bank) {
            Log::channel('activitylog')->info('Setting & configurations/ Bank updated', ['id' => $bank->id]);
        });

        static::deleted(function ($bank) {
            Log::channel('activitylog')->info('Setting & configurations/ Bank deleted', ['id' => $bank->id]);
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