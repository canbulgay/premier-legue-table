<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Team::insert([
            ['name' => 'Manchester City','stadium' => 'Etihad','strength' => rand(80,100)],
            ['name' => "Chelsea",'stadium'=> "Stamford Bridge",'strength' => rand(80,100)],
            ['name' => "Liverpool",'stadium'=> "Anfield",'strength' => rand(80,100)],
            ['name' => "Arsenal",'stadium'=> "Emirates",'strength' => rand(80,100)],
            ['name' => "Everton",'stadium'=> "Goodison Park",'strength' => rand(80,100)],
            ['name' => "Newcastle United",'stadium'=> "St James' Park",'strength' => rand(80,100)]
        ]);
    }
}
