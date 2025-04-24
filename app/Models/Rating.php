<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    //

    protected $fillable = [
        'user_id',
        'university_id',
        'rating_rate',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function university()
    {
        return $this->belongsTo(University::class);
    }

}
