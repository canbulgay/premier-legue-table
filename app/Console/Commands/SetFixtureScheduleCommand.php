<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Fixture;
use App\Models\Team;

class SetFixtureScheduleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:fixture';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set fixture schedule for app';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
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
        $firstHalfOfSeason[] = [$constantTeam,$fixedTeams[0]];
        for($j = 1 ; $j <= ($teamsCount-2) / 2; $j++ ){
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
    $secondHalfOfSeason = array_reverse($firstHalfOfSeason);

    for ($s = 0; $s < count($secondHalfOfSeason) ; $s++) { 
        Fixture::create([
            'home_id' => $secondHalfOfSeason[$s][1],
            'away_id' => $secondHalfOfSeason[$s][0]
        ]);
    }

    $this->info('Fixture Schedule Created.');
    }
}
