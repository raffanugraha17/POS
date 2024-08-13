<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log; 

class SupplierList extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'supplier_id';
    protected $fillable = ['supplier_code','no', 'supplier', 'telephone', 'contact','address','province_id','regency_id','npwp','bank_code','flag'];

    protected $casts = [
        'flag' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($supplier) {
            $supplier->flag = true;
            $supplier->save();
        });

        static::created(function ($supplier) {
            Log::channel('activitylog')->info('Supplier created', ['id' => $supplier->id]);
        });

        static::updated(function ($supplier) {
            Log::channel('activitylog')->info('Supplier updated', ['id' => $supplier->id]);
        });

        static::deleted(function ($supplier) {
            Log::channel('activitylog')->info('Supplier deleted', ['id' => $supplier->id]);
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
    public function supplierList()
    {
        return $this->belongsTo(SupplierList::class);
    }
}
