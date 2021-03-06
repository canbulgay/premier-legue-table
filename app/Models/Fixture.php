<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    use HasFactory;

    protected $fillable = [
        'home_id',
        'away_id',
        'home_result',
        'away_result',
        'is_played',
    ];

    public function homeTeam(){

        return $this->belongsTo(Team::class,'home_id');
    }
    public function awayTeam(){

        return $this->belongsTo(Team::class,'away_id');
    }
}
