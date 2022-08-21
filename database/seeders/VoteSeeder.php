<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Vote;
use Illuminate\Database\Seeder;

class VoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classrooms = Classroom::all();
        foreach ($classrooms as $classroom) {
            $voters = $classroom->voters()->get();
            $random_voters_count = rand(20, 32);
            for ($i = 0; $i < $random_voters_count; $i++) {
                Vote::create([
                    "voter_id" => $voters[$i]->id,
                    "selected_candidate_id" => rand(1, 6),
                ]);
            }
        }
    }
}
