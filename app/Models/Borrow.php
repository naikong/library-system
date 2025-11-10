<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;
    protected $table = 'borrowdeatils';
    protected $fillable = [
        // 'borrow_name',
        'borrow_id',
        'borrow_date',
        'status',
        'return_date',        
        'price_penalty', 
        'deadline_date', 
        'qty',
        'book_id',
        'pay_id',
        'stu_id',
        'created_at',
        'updated_at'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'stu_id', 'id');
    }    
}
