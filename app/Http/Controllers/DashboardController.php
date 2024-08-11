<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() : View
    {
        return view('index', [
            'title' => 'Dashboard',
            'hal' => 'dashboard/index'
        ]);
    }
}
