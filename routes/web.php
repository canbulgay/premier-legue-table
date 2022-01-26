<?php

use App\Models\Fixture;
use App\Models\Team;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Date;
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
     * * Takımlar isimleri ile birlikte veritabanından çekilir ve array e dönüştürülür.
     * * Takım sayısı bulunur.
     */
    $teams = Team::pluck('id')->toArray();
    $teamsCount = count($teams);
    /**
     * * Takımların yerleri değiştirilir. 
     * * Random bir index numarası belirlenir ve bu index numarası ile sabit bir takım belirlenir.
     * * Sabit takım , takımların dizisinden çıkartılır.
     * * Diziden bir eleman çıkarttık şimdi indexlerini düzeltmek için array_values fonksiyonunu kullanıyoruz.
     */
    shuffle($teams);
    $index = rand(0,$teamsCount-1);
    $constantTeam = $teams[$index];   
    unset($teams[$index]);
    $fixedTeams = array_values($teams);

    /**
     * * Her bir takım kendisi dışında toplamda n-1 kadar maç yapar.
     * * 1. maç sabit olarak belirlenen takım ile sabit takımın çıkardıgımız array'in ilk elemanı ile eşleşir.
     * * Ardından başka bir döngü içerisinde dizinin elamanlarını dışardan içeriye doğru eşleştiriyoruz.
     * * Tüm takımlar eşleştiğinde dizinin son elemanını diziden çıkartıyoruz ve tekrar ilk eleman olarak diziye dahil ediyoruz.
     */

    $firstHalfOfSeason = [];

    for($i = 1 ; $i <= $teamsCount-1 ; $i++){
        echo "<br>";
        echo $i . ". Haftanın Fikstürü : <br>";
        echo "1. Maç : ".$constantTeam. " = 0 || 0 = " . $fixedTeams[0]. "<br>";
        $firstHalfOfSeason[] = [$constantTeam,$fixedTeams[0]];

        for($j = 1 ; $j <= ($teamsCount-2) / 2; $j++ ){
            echo $j+1 . ". Maç : " . $fixedTeams[$j] . " = 0 || 0 = ". $fixedTeams[count($fixedTeams) -$j] . "<br>";
            $firstHalfOfSeason[] = [$fixedTeams[$j],$fixedTeams[count($fixedTeams) -$j]];
        }
        $lastIndex = array_pop($fixedTeams);
        array_unshift($fixedTeams,$lastIndex);
    }

    for ($f = 0; $f < count($firstHalfOfSeason); $f++) {
        Fixture::create([
            'home_id' => $firstHalfOfSeason[$f][0],
            'away_id' => $firstHalfOfSeason[$f][1]
        ]);
    }
    $secondHalfOfSeason = array_values(array_reverse($firstHalfOfSeason));

    for ($s = 0; $s < count($secondHalfOfSeason) ; $s++) { 
        Fixture::create([
            'home_id' => $firstHalfOfSeason[$s][1],
            'away_id' => $firstHalfOfSeason[$s][0]
        ]);
    }
}); 

