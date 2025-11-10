<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payment';
    protected $fillable = [
        'payName',
        'price',
        'created_at',
        'updated_at'
    ];
    // public function borrowDetails()
    // {
    //     return $this->hasMany(Borrow::class, 'pay_id', 'id');
    // }
}
