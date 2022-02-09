<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fixture;
use App\Models\Point;
use App\Models\Team;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;


class MatchController extends Controller
{
    public function nextWeekScore(){
        $teams = Team::all();
        $teamsCount = count($teams);
        $teamNumberPerWeek = $teamsCount / 2;

        $matchNumber = 0;
        while ($matchNumber < $teamNumberPerWeek) {
            $matchNumber++;
            $this->nextMatchScore();
        }        

        return redirect()->back();
    }

    protected function nextMatchScore(){

        // Fixture modeli id'lere göre sıralandıktan sonra oynanmayan maçların ilkini ev sahibi ve deplasman takımının bilgileriyle nextGame değişkenine atanır.
        $nextGame = Fixture::with(['homeTeam','awayTeam'])
        ->where('is_played','not_played')
        ->orderBy('id')
        ->first();

    // Takımların güçleri ev sahibi veya deplasman olmalarına göre yeniden hesaplanır.
    $homeTeamStrength = $nextGame->homeTeam->strength;
    $homeTeamAdvantage = 0.05;
    $newHomeTeamStrength = $homeTeamStrength + ($homeTeamStrength * $homeTeamAdvantage);
                    
    $awayTeamStrength = $nextGame->awayTeam->strength;
    $awayTeamDisadvantage = 0.05;
    $newAwayTeamStrength = $awayTeamStrength - ($awayTeamStrength * $awayTeamDisadvantage);

    /**
    * * Takım güçlerinin son durumlarına göre farklı senaryolar aşşağıdaki değişkenlere göre hesaplanmıştır.
    * 
    ** homeScored = Ev sahibi takımın geçmişte ev sahibiyken attığı gollerin ortalaması.
    ** awayScored = Deplasman takımının geçmişte deplasmanda attığı gollerin ortalaması.
    ** homeConceded = Ev sahibi takımın geçmişte ev sahibiyken yediği gollerin ortalaması.
    ** awayConceded = Deplasman takımının geçmişte deplasmanda yediği gollerin ortalaması.
    */

    if($newHomeTeamStrength >= 90 and $newAwayTeamStrength <= 90){
    $homeScored = rand(2,6);
    $homeConceded = rand(0,2);
    $awayScored = rand(0,2);
    $awayConceded = rand(2,6);

    }elseif($newHomeTeamStrength <= 90 and $newAwayTeamStrength >= 90){
    $homeScored = rand(1,3);
    $homeConceded = rand(1,3);
    $awayScored = rand(2,5);
    $awayConceded = rand(0,3);

    }elseif($newHomeTeamStrength <= 90 and $newAwayTeamStrength <= 90){
    $homeScored = rand(0,3);
    $homeConceded = rand(0,3);
    $awayScored = rand(0,2);
    $awayConceded = rand(1,3);

    }else{
    $homeScored = rand(2,6);
    $homeConceded = rand(2,5);
    $awayScored = rand(1,5);
    $awayConceded = rand(2,5);
    }

    /**
    * * awayTeamGoals = Ev sahibi takımın ortalama yediği gol sayısı ile deplasman takımının ortalama attıgı gol sayısının ortalaması.
    * * homeTeamGoals = Ev sahibi takımın ortalama attığı gol sayısı ile deplasman takımının ortalama yediği gol sayısının ortalaması. 
    */

    $awayTeamGoals = (int)(($homeConceded + $awayScored) / 2);
    $homeTeamGoals = (int)(($homeScored + $awayConceded) / 2); 

    //Sonuçlar fikstür tablosuna update edilmiş bir şekilde geri gönderilir.
    $nextGame->home_result = $homeTeamGoals;
    $nextGame->away_result = $awayTeamGoals;
    $nextGame->is_played = "played";
    $nextGame->save();

    /**
    * * Takımlara ait id'ler ile puan tablosundaki ilişkileri bulunur. Ve aldıkları sonuçlara göre değerleri güncellenir.
    */
    $homeTeamPoints = Point::find($nextGame->homeTeam->id);
    $awayTeamPoints = Point::find($nextGame->awayTeam->id);

    // Oynanan maç sayısı.
    $homeTeamPoints->played = $homeTeamPoints->played + 1;
    $awayTeamPoints->played = $awayTeamPoints->played + 1;

    //Atılan ve yenilen goller.
    $homeTeamPoints->goals_for = $homeTeamPoints->goals_for + $homeTeamGoals;
    $homeTeamPoints->goals_against = $homeTeamPoints->goals_against + $awayTeamGoals;

    $awayTeamPoints->goals_for = $awayTeamPoints->goals_for + $awayTeamGoals;
    $awayTeamPoints->goals_against = $awayTeamPoints->goals_against + $homeTeamGoals;

    // Takımların gol sayısına göre kazanıp kazanmadıklarını belirlenmesi ve değerlerin güncellenmesi.
    if($homeTeamGoals > $awayTeamGoals){

    $homeTeamPoints->won = $homeTeamPoints->won + 1;
    $awayTeamPoints->lost = $awayTeamPoints->lost + 1;

    }elseif($homeTeamGoals < $awayTeamGoals){

    $homeTeamPoints->lost = $homeTeamPoints->lost + 1;
    $awayTeamPoints->won = $awayTeamPoints->won + 1;

    }else{

    $homeTeamPoints->drawn = $homeTeamPoints->drawn + 1;
    $awayTeamPoints->drawn = $awayTeamPoints->drawn + 1;

    }

    $homeTeamPoints->save();
    $awayTeamPoints->save();

    }
}
