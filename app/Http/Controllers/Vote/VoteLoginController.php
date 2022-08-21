<?php

namespace App\Http\Controllers\Vote;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Models\Voter;
use Illuminate\Http\Request;

class VoteLoginController extends Controller
{
    public function __invoke()
    {
        $cover_image = Configuration::get("cover_image");
        $title = Configuration::get("title");
        $subtitle = Configuration::get("subtitle");
        $hide_osis_mpk = Configuration::get("hide_osis_mpk");

        return view(
            "vote.login",
            compact("cover_image", "title", "subtitle", "hide_osis_mpk")
        );
    }

    public function login(Request $request)
    {
        $nis = $request->input("nis");
        $access_code = $request->input("access_code");

        $voter = Voter::where("nis", $nis)->first();
        if ($voter) {
            if (
                $voter
                    ->vote()
                    ->get()
                    ->count() > 0
            ) {
                // already voted
                return back()
                    ->withErrors([
                        "Hak suara telah digunakan. Silahkan tunggu hasilnya.",
                    ])
                    ->withInput();
            } else {
                // check access code
                if ($access_code == $voter->access_code) {
                    // login success
                    session()->put("nis", $nis);
                    return redirect()->route("vote");
                } else {
                    // invalid access code
                    return back()
                        ->withErrors([
                            "Kode akses tidak valid. Harap periksa kembali.",
                        ])
                        ->withInput();
                }
            }
        } else {
            return back()
                ->withErrors(["NIS tidak terdaftar di database."])
                ->withInput();
        }
    }
}
