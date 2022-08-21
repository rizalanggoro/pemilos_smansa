<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Grade;
use App\Models\Voter;
use App\Models\Classroom;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class VoterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classroom_names = [
            "X MIPA 1",
            "X MIPA 2",
            "X MIPA 3",
            "X MIPA 4",
            "X MIPA 5",
            "X MIPA 6",
            "X IPS 1",
            "X IPS 2",
            "X IPS 3",
            "X IPS 4",
            "XI MIPA 1",
            "XI MIPA 2",
            "XI MIPA 3",
            "XI MIPA 4",
            "XI MIPA 5",
            "XI MIPA 6",
            "XI IPS 1",
            "XI IPS 2",
            "XI IPS 3",
            "XI IPS 4",
            "XII MIPA 1",
            "XII MIPA 2",
            "XII MIPA 3",
            "XII MIPA 4",
            "XII MIPA 5",
            "XII MIPA 6",
            "XII IPS 1",
            "XII IPS 2",
            "XII IPS 3",
            "XII IPS 4",
        ];

        $nis = 1;
        foreach ($classroom_names as $classroom_name) {
            $grade_name = explode(" ", $classroom_name)[0];
            $classroom = Classroom::firstOrCreate([
                "name" => $classroom_name,
                "grade" => $grade_name,
            ]);

            $faker = Factory::create("id_ID");
            for ($i = 0; $i < 32; $i++) {
                $classroom->voters()->create([
                    "nis" => $nis,
                    "name" => $faker->name(),
                    "access_code" => rand(111111, 999999),
                ]);
                $nis++;
            }
        }
    }
}
