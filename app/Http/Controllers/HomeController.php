<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        // jika status sudah login maka arahkan ke user
        if ($request->session()->exists("user")) {
            return redirect('/home/todolist');
        } else {
            // jika belum maka arahkan ke menu login
            return redirect('/user/login');
        }
    }
}
