<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'student';
    protected $fillable = [
        'stu_id',
        'name',
        'phone',
        'year_id',
        'fac_id',
        'borrow_qty',
        'user_id'
    ];
    public function year()
    {
        return $this->belongsTo(Year::class);
    }
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'fac_id', 'id'); // fac_id
    }
}
