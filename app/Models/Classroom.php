<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;
    protected $fillable = ["name", "grade"];

    public function voters()
    {
        return $this->hasMany(Voter::class, "classroom_id", "id");
    }
}
