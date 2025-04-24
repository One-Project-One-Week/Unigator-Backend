<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accomodation extends Model
{
    //
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
