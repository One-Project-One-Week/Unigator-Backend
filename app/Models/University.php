<?php

namespace App\Models;

use App\Models\Rating;
use App\Enums\University\Type;
use Laravel\Sanctum\HasApiTokens;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class University extends Model
{
    use HasFactory, Notifiable, HasApiTokens;
    //

    protected $fillable = [
        'user_id',
        'description',
        'country',
        'city',
        'address',
        'ranking',
        'logo',
        'cover',
        'founded',
        'type',
        'no_of_students',
        'website_link',
        'slug',
        'image',
        'application_link'
    ];

    protected $casts = [
        'image' => 'array',
        'type' => Type::class,
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function programs()
    {
        return $this->hasMany(Program::class, 'university_id');
    }

    public function accommodations()
    {
        return $this->hasMany(Accomodation::class, 'university_id');
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class, 'university_id');
    }
}
