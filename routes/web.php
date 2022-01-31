<?php

use App\Models\Fixture;
use App\Models\Team;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');


Route::get('/test',function(){

    /**
     * * Fixture modeli id'lere göre sıralandıktan sonra oynanmayan maçların ilkini ev sahibi ve deplasman takımının bilgileriyle nextGame değişkenine atanır.
     */
    
    $nextGame = Fixture::with(['homeTeam','awayTeam'])
                ->where('is_played','not_played')
                ->orderBy('id')
                ->first();
    
    $homeTeamStrength = $nextGame->homeTeam->strength;
        $homeTeamAdvantage = 0.05;
            $newHomeTeamStrength = $homeTeamStrength - ($homeTeamStrength * $homeTeamAdvantage);
                            
    $awayTeamStrength = $nextGame->awayTeam->strength;
        $awayTeamDisadvantage = -0.05;
            $newAwayTeamStrength = $awayTeamStrength - ($awayTeamStrength*$awayTeamDisadvantage);

    /**
     * * Takım güçlerin durumuna göre aşşağıdaki değişkenler hesaplanmıştır.
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

    $nextGame->home_result = $homeTeamGoals;
    $nextGame->away_result = $awayTeamGoals;
    $nextGame->is_played = "played";
    $nextGame->save();
    
});