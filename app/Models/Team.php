<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    
    
    public function points()
    {
        return $this->hasOne(Point::class);
    }
    public function homeTeamFixture()
    {
        return $this->hasMany(Fixture::class,'home_id');
    }
    public function awayTeamFixture()
    {
        return $this->hasMany(Fixture::class,'away_id');
    }
}
