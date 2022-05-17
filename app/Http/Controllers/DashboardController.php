<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function view (Request $request) {
        return view('Dashboard');
    }
}
