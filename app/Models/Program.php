<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Program extends Model
{
    //
    protected $casts = [
        'detail' => 'array',
        'application_requirement' => 'array',
        "intake" => 'array',
    ];

    use HasFactory, Notifiable, HasApiTokens;
    use \Illuminate\Database\Eloquent\Concerns\HasUuids;

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'university_id',
        'name',
        'category_id',
        'detail',
        'degree_type',
        'duration',
        'application_requirement',
        'intake',
        'payment_plan',
        'category_id',
        'level',
        'average_cost'
    ];

    public function universities()
    {
        return $this->belongsTo(University::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function scholarships()
    {
        return $this->hasMany(Scholarship::class, 'program_id');
    }
    
}