<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Accomodation extends Model
{
    //
    use HasFactory, Notifiable, HasApiTokens;
    protected $fillable =[
        'university_id',
        'estimated_cost',
        'type',
    ];

    protected $table = 'accomodations';
    public function university()
    {
        return $this->belongsTo(University::class, 'university_id');  // Foreign key is 'university_id'
    }
}
