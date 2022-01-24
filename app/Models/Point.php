<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory;

    /**
    * * Points ve goal difference columnlarını manuel olarak değiştirmek istemediğim için fillable kısmına almadım.
    * ? fillable kısmına almadıgım takdirde veri tabanında değişen değerler sonucunda kendi kendine değişirler mi?
     */
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
