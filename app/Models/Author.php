<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use SoftDeletes;

    // soft delete and date_of_birth field 
    protected $dates = ['deleted_at', 'dob'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'dob',
    ];

    public function path()
    {
    	return 'api/authors' . $this->id;
    }

    // changing the dob to carbon standard
    public function setDobAttribute($dob)
    {
    	$this->attributes['dob'] = Carbon::parse($dob);

    }
}
