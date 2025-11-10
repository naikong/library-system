<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use HasFactory;
    
    protected $table = 'gender';
    protected $fillable = [
       ' gender_kh',
       'gender_kh_full',
        'gender_ens',
        'gender_en_full',
    ];
}
