<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tournament;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $tournaments = Tournament::where('start_date', '>=', Carbon::today())
                                 ->orderBy('start_date', 'asc')
                                 ->get();

        return view('dashboard', compact('tournaments'));
    }
}
