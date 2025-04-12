<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // menuju tampilan loginnya
    public function login()
    {
        return response()
            ->view("user.login", [
                "title" => "Login"
            ]);
    }

    // aksi loginnya
    public function doLogin(Request $request)
    {
        $user = $request->input('user');
        $password = $request->input('password');

        // jika pengguna tidak memasukkan username ataupun password
        if (empty($user) || empty($password)) {
            return response()->view("user.login", [
                "title" => "Login",
                "error" => "username or password are required"
            ]);
        }

        // jika berhasil login masukkan data user kedalam cookie
        if ($this->userService->login($user, $password)) {
            $request->session()->put("user", $user);
            return redirect("/");
        }

        // jika user dan password ada tapi salah
        return response()->view("User.login", [
            "title" => "Login",
            "error" => "username or password wrong"
        ]);

    }

    // aksi logoutnya
    public function doLogout(Request $request)
    {
        // dd($request);
        // exit;
        $request->session()->forget("user");
        return redirect("/");
    }
}
