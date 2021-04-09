<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
	use SoftDeletes;

	// soft delete  
    protected $date = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'author',
    ];

    public function path()
    {
    	// using slug in url
    	// return 'api/books/' . $this->id . '-' . Str::slug($this->title);

    	return 'api/books/' . $this->id;
    }
}
