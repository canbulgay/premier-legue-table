<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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

        $teams = [
            ['name' => 'Manchester City','stadium' => 'Etihad',],
            ['name' => "Chelsea",'stadium'=> "Stamford Bridge",],
            ['name' => "Liverpool",'stadium'=> "Anfield",],
            ['name' => "Arsenal",'stadium'=> "Emirates",]
        ];
        Team::insert($teams);
    }
}
