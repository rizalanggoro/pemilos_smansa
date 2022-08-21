<?php

namespace App\Imports;

use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VoterImport implements ToModel, WithHeadingRow
{
    public $classroom;
    public function __construct($classroom)
    {
        $this->classroom = $classroom;
    }

    public function model(array $row)
    {
        $nis = $row["nis"];
        $name = $row["name"];

        $this->classroom->voters()->create([
            "nis" => $nis,
            "name" => $name,
            "access_code" => rand(111111, 999999),
        ]);
    }
}
