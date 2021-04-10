<?php

namespace App\Models;

use App\Models\Author;
use App\Models\Reservation;
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

    // a book is checked out to a use
    public function checkOut($user)
    {
        $this->reservation()->create([
            'user_id' => $user->id,
            'check_out_at' => now()
        ]);
    }

    // a book is returned 
    public function checkIn($user)
    {
        $reservation = $this->reservation()->where('user_id', $user->id)
                                ->whereNotNull('check_out_at')
                                ->whereNull('check_in_at')
                                ->first();

        if (is_null($reservation)) {
            throw new \Exception("This user have not checked out this book", 1);
            
        }
        // update the reservation table
        $reservation->update([
            'check_in_at' => now(),
            // 'check_out_at' => null
        ]);
    }

    public function reservation()
    {
        return $this->hasMany(Reservation::class);
    }
}
