<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class DashboardLoginController extends Controller
{
    public function __invoke()
    {
        return view("dashboard.login.login");
    }

    public function login(Request $request)
    {
        $email = $request->input("email");
        $password = $request->input("password");

        $admin = Admin::where("email", $email)->first();
        if ($admin) {
            if (Hash::check($password, $admin->password)) {
                session()->put("email", $email);
                return redirect()->route("dashboard");
            } else {
                return back()
                    ->withErrors(
                        "Kata sandi tidak cocok. Harap periksa kembali"
                    )
                    ->withInput();
            }
        } else {
            return back()
                ->withErrors("Email tidak ditemukan!")
                ->withInput();
        }
    }

    public function logout()
    {
        session()->forget("email");
        return redirect()->route("dashboard");
    }
}
