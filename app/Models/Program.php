<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Program extends Model
{
    //
<<<<<<< HEAD
<<<<<<< Updated upstream
=======
=======
>>>>>>> 8acc4811af7b2c9a4f292da4251834d3b8fe6ecc
    protected $casts = [
        'detail' => 'array',
        'application_requirement' => 'array',
    ];
<<<<<<< HEAD

    use HasFactory, Notifiable, HasApiTokens;
>>>>>>> Stashed changes
=======
    
    use HasFactory, Notifiable, HasApiTokens;
>>>>>>> 8acc4811af7b2c9a4f292da4251834d3b8fe6ecc
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
        'category_id',
        'level',
    ];

    public function universities()
    {
        return $this->belongsTo(University::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}