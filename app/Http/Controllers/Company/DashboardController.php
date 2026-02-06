<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        return view('company.dashboard.index');
    }
}
