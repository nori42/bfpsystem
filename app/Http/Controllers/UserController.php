<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\User;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function index(){

        return view('users.index');
    }

    public function authenticate() {
        
        return redirect('/establishments');
    }

    public function users() {
        
        return redirect('/establishments');
    }
}
