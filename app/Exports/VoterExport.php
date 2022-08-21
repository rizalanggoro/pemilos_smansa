<?php

namespace App\Exports;

use App\Models\Voter;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VoterExport implements FromCollection, WithHeadings
{
    private $classroom_id;
    public function __construct($classroom_id)
    {
        $this->classroom_id = $classroom_id;
    }

    public function headings(): array
    {
        return ["NIS", "Nama", "Kode akses"];
    }

    public function collection()
    {
        return Voter::select("nis", "name", "access_code")
            ->where("classroom_id", $this->classroom_id)
            ->get();
    }
}
