<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Visit;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // dd(Carbon::now()->month);
        $companyCount = Company::count();
        $visitorCount = User::count();
        $completedWeek = Visit::whereRaw('DATE(updated_at) >= ?', [Carbon::parse('last Monday')->toDateString()])->where('status', '=', 'COMPLETED')->count();
        $totalVisitsWeek = Visit::whereRaw('DATE(created_at) >= ?', [Carbon::parse('last Monday')->toDateString()])->count();
        $completedMonth = Visit::whereRaw('DATE(updated_at) >= ?', [Carbon::now()->startOfMonth()->toDateString()])->where('status', '=', 'COMPLETED')->count();
        $totalVisitsMonth = Visit::whereRaw('DATE(created_at) >= ?', [Carbon::now()->startOfMonth()->toDateString()])->count();
        $completedYear = Visit::whereRaw('YEAR(updated_at) = ?', [Carbon::now()->year])->where('status', '=', 'COMPLETED')->count();
        $totalVisitsYear = Visit::whereRaw('YEAR(created_at) = ?', [Carbon::now()->year])->count();

        $scheduled_visits = Visit::with(['branch', 'questionnaire'])->where(function($query) {
            $query->where('status', 'IN_PROGRESS')
                ->orWhere('status', 'ASSIGNED');
        })->get();

        return view('admin.dashboard.index', compact('companyCount', 'visitorCount', 'completedWeek', 'totalVisitsWeek', 'completedMonth', 'totalVisitsMonth', 'completedYear', 'totalVisitsYear','scheduled_visits'));
    }
}
