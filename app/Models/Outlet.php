<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log; // Import Log class
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Outlet extends Model implements HasMedia
{
    use SoftDeletes,InteractsWithMedia;
    protected $primaryKey = 'outlet_id';
    protected $fillable = ['outlet_code','outlet_logo','outlet_name','outlet_telephone','outlet_address','province_id',
    'regency_id',
    'district_id',
    'village_id','flag',];

    protected $casts = [
        'flag' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($outlet) {
            $outlet->flag = true;
            $outlet->save();
        });

        static::created(function ($outlet) {
            Log::channel('activitylog')->info('Outlet created', ['id' => $outlet->id]);
        });

        static::updated(function ($outlet) {
            Log::channel('activitylog')->info('Outlet updated', ['id' =>$outlet->id]);
        });

        static::deleted(function ($outlet) {
            Log::channel('activitylog')->info('Outlet deleted', ['id' =>$outlet->id]);
        });
    }

    public static function logCrudOperation($activity, $model)
    {
        $userId = auth()->id();
        $modelName = get_class($model);
        $tableName = $model->getTable();

        // Implement logic to log CRUD operations if needed
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
   
}

