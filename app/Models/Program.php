<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    //
    use \Illuminate\Database\Eloquent\Concerns\HasUuids;

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'university_id',
        'name',
        'detail',
        'degree_type',
        'duration',
        'application_requirement',
        'intake',
        'payment_plan',
    ];

    public function universities()
    {
        return $this->belongsTo(University::class);
    }
}