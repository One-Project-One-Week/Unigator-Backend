<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Scholarship extends Model
{
    //
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'program_id',
        'type',
        'scholarship_percentage',
    ];
    protected $casts = [
        'scholarship_percentage' => 'integer',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
}
