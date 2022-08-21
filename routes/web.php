<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vote\VoteController;
use App\Http\Controllers\Vote\VoteLoginController;
use App\Http\Controllers\Dashboard\RecapController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DashboardLoginController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\PublicMiddleware;
use App\Models\Classroom;
use App\Models\Voter;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("private", [VoteController::class, "viewPrivate"])->name(
    "vote.private"
);
Route::prefix("/")
    ->middleware(PublicMiddleware::class)
    ->group(function () {
        Route::get("/", VoteController::class)->name("vote");
        Route::get("logout", [VoteController::class, "logout"]);
        Route::get("thanks", [VoteController::class, "thanks"])->name(
            "vote.thanks"
        );

        Route::post("vote", [VoteController::class, "vote"]);

        Route::prefix("login")->group(function () {
            Route::get("/", VoteLoginController::class)->name("vote.login");
            Route::post("/", [VoteLoginController::class, "login"]);
        });
    });

Route::get("dashboard/login", DashboardLoginController::class)->name(
    "dashboard.login"
);
Route::post("dashboard/login", [DashboardLoginController::class, "login"]);
Route::get("dashboard/logout", [DashboardLoginController::class, "logout"]);

Route::prefix("dashboard")
    ->middleware(AdminMiddleware::class)
    ->group(function () {
        Route::get("/", DashboardController::class)->name("dashboard");

        // candidate page
        Route::prefix("candidate")->group(function () {
            // view
            Route::get("create", [
                DashboardController::class,
                "viewCreateCandidate",
            ]);
            Route::get("update/{candidate_id}", [
                DashboardController::class,
                "viewUpdateCandidate",
            ]);
            Route::get("delete-all", [
                DashboardController::class,
                "viewDeleteAllCandidate",
            ]);

            // function
            Route::post("create", [
                DashboardController::class,
                "createCandidate",
            ]);
            Route::post("update", [
                DashboardController::class,
                "updateCandidate",
            ]);
            Route::get("delete/{candidate_id}", [
                DashboardController::class,
                "deleteCandidate",
            ]);
            Route::delete("delete-all", [
                DashboardController::class,
                "deleteAllCandidate",
            ]);
        });

        // voter page
        Route::prefix("voter")->group(function () {
            Route::get("{classroom_index}", [
                DashboardController::class,
                "voter",
            ])
                ->whereNumber("classroom_index")
                ->name("dashboard.voter");
            Route::get("delete/all", [
                DashboardController::class,
                "viewDeleteAllVoter",
            ]);
            Route::delete("delete/all", function () {
                Classroom::truncate();
                Voter::truncate();
                return redirect(url("dashboard/voter/0"));
            });

            //* import
            Route::get("import", [
                DashboardController::class,
                "viewImportVoter",
            ]);
            Route::post("import", [DashboardController::class, "importVoter"]);

            //* export
            Route::get("export", [
                DashboardController::class,
                "viewExportVoter",
            ])->name("dashboard.voter.export");
            Route::get("export/all", [
                DashboardController::class,
                "exportAllVoter",
            ]);
            Route::get("export/download/all", [
                DashboardController::class,
                "downloadAllVoter",
            ]);
            Route::delete("export/all", function () {
                Storage::disk("public")->deleteDirectory("exports/voters");
                return redirect()->route("dashboard.voter.export");
            });
        });

        // class page
        Route::prefix("class")->group(function () {
            Route::get("/", [DashboardController::class, "viewClass"]);
            Route::get("clear/{classroom_id}", [
                DashboardController::class,
                "clearClassroom",
            ]);
            Route::get("delete/{classroom_id}", [
                DashboardController::class,
                "deleteClassroom",
            ]);
        });

        // setting page
        Route::prefix("setting")->group(function () {
            Route::get("/", [DashboardController::class, "viewSetting"])->name(
                "dashboard.setting"
            );
            Route::post("/", [DashboardController::class, "setting"]);
            Route::get("cover-image", [
                DashboardController::class,
                "viewCoverImage",
            ])->name("dashboard.setting.cover-image");
            Route::get("cover-image/delete", [
                DashboardController::class,
                "deleteCoverImage",
            ]);
            Route::post("cover-image", [
                DashboardController::class,
                "coverImage",
            ]);
        });

        // recap page
        Route::prefix("/recap")->group(function () {
            Route::get("/", RecapController::class);
            Route::get("/grade/{grade}/class/{class_index}", [
                RecapController::class,
                "grade",
            ]);
            Route::get("/votes", [RecapController::class, "votes"]);
            Route::get("/graph", [RecapController::class, "graph"]);
        });
    });
