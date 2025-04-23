<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    //

    protected $fillable = [
        'user_id',
        'description',
        'country',
        'city',
        'ranking',
        'logo',
        'slug',
        'images',
    ];
   public function user()
   {
        return $this->belongsTo(User::class);
   }

   public function majors()
   {
        return $this->hasMany(Program::class, 'university_id');
   }

   public function accommodations()
   {
       return $this->hasMany(Accomodation::class, 'university_id');
   }
}
