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
        'start_at'
    ];

    public function homeTeam(){

        $this->belongsTo(Team::class,'home_id');
    }
    public function awayTeam(){

        $this->belongsTo(Team::class,'away_id');
    }
}
