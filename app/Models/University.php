<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;



use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory, Notifiable, HasApiTokens;
    //

    protected $fillable = [
        'user_id',
        'description',
        'country',
        'city',
        'ranking',
        'logo',
        'cover',
        'founded',
        'type',
        'no_of_students',
        'website_link',
        'slug',
        'image',
    ];

    protected $casts = [
        'image' => 'array',
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
