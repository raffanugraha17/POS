<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $table = 'villages';
    protected $fillable = ['id', 'district_id', 'name'];

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}