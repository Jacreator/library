<?php

namespace App\Models;

use App\Models\Author;
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
        'author_id',
    ];

    public function path()
    {
    	// using slug in url
    	// return 'api/books/' . $this->id . '-' . Str::slug($this->title);

    	return 'api/books/' . $this->id;
    }

    // set author or create one
    public function setAuthorIdAttribute($author)
    {
        $this->attributes['author_id'] = (Author::firstOrCreate([
                    'name' => $author
                ]))->id;
    }
}
