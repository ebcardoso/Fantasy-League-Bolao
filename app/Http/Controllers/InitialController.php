<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InitialController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
        
    }

    public function index() 
    {
        if (Auth::user()->type_user == 1) {
            return redirect()->route('dashboard.index');
        } else {
            return redirect()->route('game.index');
        }
    }
}