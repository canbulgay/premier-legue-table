<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory;

    protected $fillable = [
        'played',
        'won',
        'drawn',
        'lost',
        'goals_for',
        'goals_against'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
