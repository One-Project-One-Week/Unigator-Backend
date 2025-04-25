<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class Rating extends Model
{
    //

    use HasFactory, Notifiable, HasApiTokens;

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
