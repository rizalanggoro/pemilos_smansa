<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Candidate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $candidates = Storage::disk("public")->files("candidates");
        $no = 1;
        $colors = [
            "#f44336",
            "#9c27b0",
            "#3f51b5",
            "#2196f3",
            "#009688",
            "#795548",
        ];
        foreach ($candidates as $candidate) {
            // $photo = str_replace("candidates/", "", $candidate);
            $faker = Factory::create();

            $faker = Factory::create("id_ID");
            $paragraphs = $faker->paragraphs(10);
            $collection = collect($paragraphs)
                ->map(function ($data) {
                    return "<p>$data</p>";
                })
                ->toArray();
            $data = implode("", $collection);

            Candidate::create([
                "name" => $faker->name("male"),
                "no" => $no,
                "color" => $colors[$no - 1],
                "photo" => $candidate,
                "detail" => $data,
            ]);
            $no++;
        }
    }
}
