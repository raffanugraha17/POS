<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;
   
    protected $primaryKey = 'id';
     protected $fillable = [
        'name',
        'description',
        'qr_code',
    ];
}