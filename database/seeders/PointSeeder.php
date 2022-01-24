<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\Point;

class PointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = Team::get();
        $numberOfTeams = $teams->count();

        for($i = 1 ; $i <= $numberOfTeams ; $i++) 
        {   
            $point = Point::insert([
                'team_id' => $i,
            ]);
        }
    }
}
