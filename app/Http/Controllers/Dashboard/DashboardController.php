<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\VoterExport;
use Faker\Factory;
use App\Models\Candidate;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\VoterImport;
use App\Models\Classroom;
use App\Models\Configuration;
use App\Models\Voter;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use ZipStream\Option\Archive;
use ZipStream\ZipStream;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $candidates = Candidate::select()
            ->orderBy("no")
            ->get();
        return view("dashboard.content.candidate", compact("candidates"));
    }

    public function voter($classroom_index)
    {
        $classrooms = Classroom::with("voters")->get();
        $classroom_count = $classrooms->count();
        $classroom = $classrooms[$classroom_index] ?? null;

        $voters = null;
        if (isset($classroom)) {
            $voters = $classroom->voters()->get();
        }

        return view(
            "dashboard.content.voter",
            compact("voters", "classroom", "classroom_index"),
            ["classrooms_count" => $classroom_count]
        );
    }

    public function viewSetting()
    {
        $title = Configuration::get("title");
        $subtitle = Configuration::get("subtitle");
        $hide_from_public = Configuration::get("hide_from_public");
        $hide_osis_mpk = Configuration::get("hide_osis_mpk");
        $confirmation_message = Configuration::get("confirmation_message");
        $thanks_message = Configuration::get("thanks_message");
        $thanks_page_timeout = Configuration::get("thanks_page_timeout");

        return view(
            "dashboard.content.setting",
            compact(
                "title",
                "subtitle",
                "hide_from_public",
                "hide_osis_mpk",
                "confirmation_message",
                "thanks_message",
                "thanks_page_timeout"
            )
        );
    }

    public function viewClass()
    {
        $classrooms = Classroom::orderBy("name")->get();
        return view("dashboard.content.class", compact("classrooms"));
    }

    // ? setting function
    public function setting(Request $request)
    {
        $title = $request->title;
        $subtitle = $request->subtitle;
        $hide_from_public = $request->hide_from_public;
        $hide_osis_mpk = $request->hide_osis_mpk;
        $confirmation_message = $request->confirmation_message;
        $thanks_message = $request->thanks_message;
        $thanks_page_timeout = $request->thanks_page_timeout;

        Configuration::replace("title", $title);
        Configuration::replace("subtitle", $subtitle);
        Configuration::replace(
            "hide_from_public",
            $hide_from_public ?? "false"
        );
        Configuration::replace("hide_osis_mpk", $hide_osis_mpk ?? "false");
        Configuration::replace("confirmation_message", $confirmation_message);
        Configuration::replace("thanks_message", $thanks_message);
        Configuration::replace("thanks_page_timeout", $thanks_page_timeout);

        return back();
    }
    // ? end setting function

    // * candidate submenu
    public function viewCreateCandidate()
    {
        return view("dashboard.content.candidate.create");
    }

    public function viewUpdateCandidate($candidate_id)
    {
        $candidate = Candidate::where("id", $candidate_id)->first();
        return view("dashboard.content.candidate.update", compact("candidate"));
    }

    public function viewDeleteAllCandidate()
    {
        return view("dashboard.content.candidate.delete-all");
    }

    //? function
    public function createCandidate(Request $request)
    {
        $photo = $request->file("photo");
        $photo_name = Storage::disk("public")->put("candidates", $photo);
        if ($photo_name) {
            $name = $request->input("name");
            $no = $request->input("no");
            $color = $request->input("color");
            $detail = $request->input("detail");

            $candidate = Candidate::create([
                "name" => $name,
                "no" => $no,
                "color" => $color,
                "photo" => $photo_name,
                "detail" => htmlentities($detail),
            ]);
            if ($candidate) {
                return redirect()->route("dashboard");
            } else {
                return back()->withInput();
            }
        } else {
            return back()->withInput();
        }
    }

    public function updateCandidate(Request $request)
    {
        $id = $request->input("id");
        $name = $request->input("name");
        $no = $request->input("no");
        $color = $request->input("color");
        $detail = $request->input("detail");

        $candidate = Candidate::where("id", $id)->first();

        $photo = $request->file("photo");
        $photo_name = null;
        if ($photo) {
            // delete previous candidate photo
            Storage::disk("public")->delete($candidate->photo);

            // store new candidate photo
            $photo_name = Storage::disk("public")->put("candidates", $photo);
        }

        // update candidate info
        $candidate->name = $name;
        $candidate->no = $no;
        $candidate->color = $color;
        $candidate->photo = $photo_name ?? $candidate->photo;
        $candidate->detail = htmlentities($detail);

        // save new candidate info
        $candidate->save();

        // redirect to dashboard
        return redirect()->route("dashboard");
    }

    public function deleteAllCandidate()
    {
        Candidate::truncate();
        return redirect()->route("dashboard");
    }

    public function deleteCandidate($candidate_id)
    {
        $result = Candidate::where("id", $candidate_id)->delete();
        if ($result) {
            return back();
        }
    }
    // * end candidate submenu

    // * voter submenu
    public function viewImportVoter()
    {
        return view("dashboard.content.voter.import");
    }

    public function viewExportVoter()
    {
        $voters = Storage::disk("public")->files("exports/voters");
        sort($voters, SORT_NATURAL);

        return view("dashboard.content.voter.export", compact("voters"));
    }

    public function viewDeleteAllVoter()
    {
        return view("dashboard.content.voter.delete-all");
    }

    //? function
    public function importVoter(Request $request)
    {
        // Classroom::truncate();
        // Voter::truncate();

        $voter_files = $request->file("voter_files");
        // dd($voter_files);
        foreach ($voter_files as $voter_file) {
            $voter_file_name = $voter_file->getClientOriginalName();
            $voter_file_ext = $voter_file->getClientOriginalExtension();
            // $voter_file_path = $voter_file->path();

            $classroom_name = str_replace(
                ".$voter_file_ext",
                "",
                $voter_file_name
            );
            $classroom_grade = explode(" ", $classroom_name)[0];

            Excel::import(
                new VoterImport(
                    Classroom::firstOrCreate([
                        "name" => $classroom_name,
                        "grade" => $classroom_grade,
                    ])
                ),
                $voter_file
            );
        }
        return redirect(url("dashboard/voter/0"));
    }

    public function downloadAllVoter()
    {
        $voters = Storage::disk("public")->files("exports/voters");

        $options = new Archive();
        $options->setSendHttpHeaders(true);

        $zip = new ZipStream("data_pemilih.zip", $options);
        foreach ($voters as $voter) {
            $voter_name = str_replace("exports/voters/", "", $voter);
            $zip->addFileFromPath(
                $voter_name,
                public_path("storage/exports/voters/$voter_name")
            );
        }
        $zip->finish();
        return redirect()->route("dashboard.voter.export");
    }

    public function exportAllVoter()
    {
        $classrooms = Classroom::all();
        foreach ($classrooms as $classroom) {
            $classroom_id = $classroom->id;
            $file_name = $classroom_id . "_" . $classroom->name . ".xlsx";
            Excel::store(
                new VoterExport($classroom->id),
                "exports/voters/" . $file_name,
                "public"
            );
        }
        return redirect()
            ->route("dashboard.voter.export")
            ->with("status", "success");
    }
    // * end voter submenu

    // * classroom menu
    function clearClassroom($classroom_id)
    {
        Voter::where("classroom_id", $classroom_id)->delete();
        return back();
    }

    function deleteClassroom($classroom_id)
    {
        Voter::where("classroom_id", $classroom_id)->delete();
        Classroom::where("id", $classroom_id)->delete();
        return back();
    }
    // * end classroom menu

    // * setting submenu
    public function viewCoverImage()
    {
        $cover_image = Configuration::where("key", "cover_image")->first();
        return view(
            "dashboard.content.setting.cover-image",
            compact("cover_image")
        );
    }

    public function coverImage(Request $request)
    {
        $cover_image = $request->file("cover_image");

        if ($cover_image) {
            $uploaded_cover_image = Storage::disk("public")->put(
                "cover-image",
                $cover_image
            );
            if ($uploaded_cover_image) {
                Configuration::replace("cover_image", $uploaded_cover_image);
            }
        }
        return redirect()->route("dashboard.setting.cover-image");
    }

    public function deleteCoverImage()
    {
        if (Storage::disk("public")->exists("cover-image")) {
            Storage::disk("public")->deleteDirectory("cover-image");
            Configuration::replace("cover_image", "");
        }
        return redirect()->route("dashboard.setting.cover-image");
    }
    // * end setting submenu
}
