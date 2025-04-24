<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Category extends Model
{
    use HasFactory, Notifiable, HasApiTokens;
    protected $fillable = [
        'name',
    ];

    public function programs()
    {
        return $this->hasMany(Program::class);
    }
}
