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
        'image',
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
}
