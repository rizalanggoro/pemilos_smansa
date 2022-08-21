<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    use HasFactory;
    protected $fillable = ["nis", "name", "access_code", "classroom_id"];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, "classroom_id", "id");
    }

    public function vote()
    {
        return $this->belongsTo(Vote::class, "id", "voter_id");
    }
}
