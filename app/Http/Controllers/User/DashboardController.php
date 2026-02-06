<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Visit;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::guard('web')->user()->id;
        $email_attachment_file = Setting::where('type','email_attachment_file')->first();

        $counts = getVisitCounts($userId);

        $scheduled_visits = Visit::with(['branch', 'questionnaire'])
            ->where(function ($query) {
                $query->where('status', 'IN_PROGRESS')
                    ->orWhere('status', 'ASSIGNED');
            })
            ->where('visitor_id', $userId)
            ->get();

        return view('user.dashboard.index', [
            'available' => $counts['available'],
            'scheduled' => $counts['scheduled'],
            'pending'   => $counts['pending'],
            'completed' => $counts['completed'],
            'scheduled_visits' => $scheduled_visits,
            'email_attachment_file' => $email_attachment_file,
        ]);
    }


}
