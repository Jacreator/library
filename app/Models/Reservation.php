<?php

namespace App\Models;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use SoftDeletes;

	// timestapm for the table  
    protected $date = ['deleted_at', 'check_out_at', 'check_in_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'book_id',
        'check_out_at',
        'check_in_at'
    ];

    public function books()
    {
    	return $this->belongsTo(Book::class);
    }
}
