<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    //
<<<<<<< Updated upstream
=======
    protected $casts = [
        'detail' => 'array',
        'application_requirement' => 'array',
    ];

    use HasFactory, Notifiable, HasApiTokens;
>>>>>>> Stashed changes
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