<?php

namespace App\Http\Controllers\Vote;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Configuration;
use App\Models\Vote;
use App\Models\Voter;

class VoteController extends Controller
{
    public function __invoke()
    {
        $nis = session()->get("nis");
        $voter = Voter::where("nis", $nis)->first();
        if (isset($nis)) {
            $title = Configuration::get("title");
            $subtitle = Configuration::get("subtitle");
            $cover_image = Configuration::get("cover_image");
            $hide_osis_mpk = Configuration::get("hide_osis_mpk");
            $confirmation_message = Configuration::get("confirmation_message");

            $candidates = Candidate::select()
                ->orderBy("no")
                ->get();

            return view(
                "vote.index",
                compact(
                    "candidates",
                    "voter",
                    "title",
                    "subtitle",
                    "hide_osis_mpk",
                    "cover_image",
                    "confirmation_message"
                )
            );
        } else {
            return redirect()->route("vote.login");
        }
    }

    public function logout()
    {
        session()->forget("nis");
        return redirect()->route("vote.login");
    }

    public function vote(Request $request)
    {
        $voter_id = $request->input("voter-id");
        $selected_candidate_id = $request->input("selected-candidate-id");

        Vote::create([
            "voter_id" => $voter_id,
            "selected_candidate_id" => $selected_candidate_id,
        ]);
        return redirect()->route("vote.thanks");
    }

    public function thanks()
    {
        // remove session
        session()->forget("nis");

        $thanks_message = Configuration::get("thanks_message");
        $thanks_page_timeout = Configuration::get("thanks_page_timeout");

        return view(
            "vote.thanks",
            compact("thanks_message", "thanks_page_timeout")
        );
    }

    public function viewPrivate()
    {
        return view("vote.private");
    }
}
