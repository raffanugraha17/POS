<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log; // Import Log class
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class CustomerList extends Model implements HasMedia
{
    use SoftDeletes,InteractsWithMedia;
    

    protected $primaryKey = 'customer_id';
    protected $fillable = ['membership_id','customer_code', 'customer_name', 'customer_telephone', 'customer_age', 'customer_occupation', 'customer_address', 'customer_gender','birth_date','province_id','regency_id','district_id','village_id', 'flag'];

    protected $casts = [
        'flag' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($customerList) {
            $customerList->flag = true;
            $customerList->save();
        });

        static::created(function ($customerList) {
            Log::channel('activitylog')->info('Setting & configurations/ Customer List created', ['id' => $customerList->id]);
        });

        static::updated(function ($customerList) {
            Log::channel('activitylog')->info('Setting & configurations/ Customer List updated', ['id' => $customerList->id]);
        });

        static::deleted(function ($customerList) {
            Log::channel('activitylog')->info('Setting & configurations/ Customer List deleted', ['id' => $customerList->id]);
        });
    }

    public static function logCrudOperation($activity, $model)
    {
        $userId = auth()->id();
        $modelName = get_class($model);
        $tableName = $model->getTable();

        // Implement logic to log CRUD operations if needed
    }
    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }
}

