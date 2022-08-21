<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Vote;
use App\Models\Voter;

class RecapController extends Controller
{
    private $base_url = "dashboard/recap";

    private $classrooms_by_grade = [];
    private $grades = [];
    private $menus = [];

    private $candidates = [];
    public function __construct()
    {
        $this->classrooms_by_grade = Classroom::all()
            ->groupBy("grade")
            ->toArray();
        $this->grades = array_keys($this->classrooms_by_grade);

        // init menu
        $this->addMenu("Dashboard", "$this->base_url/");
        // init class menu
        foreach ($this->grades as $grade) {
            $this->addMenu(
                "Hasil suara kelas $grade",
                "$this->base_url/grade/$grade/class/0"
            );
        }
        $this->addMenu("Perolehan suara total", "$this->base_url/votes");
        $this->addMenu("Grafik suara total", "$this->base_url/graph");

        $this->candidates = Candidate::select()
            ->orderBy("no")
            ->get();
    }

    private function addMenu($title, $href)
    {
        $this->menus[] = ["title" => $title, "href" => $href];
    }

    public function __invoke()
    {
        return view("dashboard.recap.index", [
            "menus" => $this->menus,
        ]);
    }

    private $classroom;
    public function grade($grade, $class_index)
    {
        $grade_index = array_search($grade, $this->grades);
        $classrooms = Classroom::with("voters")
            ->where("grade", $grade)
            ->get();
        $this->classroom = $classrooms[$class_index];
        $voters = $this->classroom->voters()->get();

        $votes = Vote::whereHas("voter", function ($event) {
            return $event->where("classroom_id", "=", $this->classroom["id"]);
        })->get();
        $votes_groupped = $votes->groupBy("selected_candidate_id")->toArray();
        ksort($votes_groupped);

        return view("dashboard.recap.grade", [
            "menus" => $this->menus,
            "candidates" => $this->candidates,
            "classroom" => $this->classroom,
            "classroom_index" => $class_index,
            "classrooms_count" => $classrooms->count(),
            "grade" => $grade,
            "grade_index" => $grade_index,
            "voters_count" => $voters->count(),
            "votes" => $votes_groupped,
            "votes_count" => $votes->count(),
        ]);
    }

    public function votes()
    {
        $votes = Vote::all()
            ->groupBy("selected_candidate_id")
            ->toArray();
        ksort($votes);

        $votes_count = [];
        foreach ($this->candidates as $candidate) {
            if (key_exists($candidate->id, $votes)) {
                $votes_count[$candidate->id] = count($votes[$candidate->id]);
            } else {
                $votes_count[$candidate->id] = 0;
            }
        }

        return view("dashboard.recap.votes", [
            "menus" => $this->menus,
            "candidates" => $this->candidates,
            "votes" => $votes_count,
        ]);
    }

    public function graph()
    {
        $votes = Vote::all();
        $votes_groupped = $votes->groupBy("selected_candidate_id")->toArray();
        ksort($votes_groupped);
        $voters = Voter::all();

        return view("dashboard.recap.graph", [
            "menus" => $this->menus,
            "candidates" => $this->candidates,
            "voters_count" => $voters->count(),
            "votes" => $votes_groupped,
            "votes_count" => $votes->count(),
        ]);
    }
}
