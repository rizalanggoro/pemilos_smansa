<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;
    protected $fillable = ["voter_id", "selected_candidate_id"];

    public function voter()
    {
        return $this->belongsTo(Voter::class, "voter_id", "id");
    }
}
