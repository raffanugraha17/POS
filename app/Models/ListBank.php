<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListBank extends Model
{
    protected $table = 'listbank';
    protected $fillable = ['name', 'code'];

    public function supplierList()
    {
        return $this->hasMany(SupplierList::class);
    }
}