<?php

namespace App\Http\Controllers\User;

use App\Enums\VisitStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Visit;
use App\Models\Questionnaire;
use App\Models\User;
use App\Http\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    use ResponseTrait;

    // 🔧 Constructor Function
    public function __construct()
    {
        $this->userData = Auth::guard('web')->user();
        $this->user_id = Auth::guard('web')->user()->id;
    }

    public function index($companyId)
    {

        $company = Company::where('company_id','=',$companyId)->first();
        $companyId = $company->id;
        $allBranch = Branch::where('company_id',$companyId)->get();

        $data = [
            'company' => $company,
            'companyId' => $companyId,
            'allBranch' => $allBranch,
            'user_id' => $this->user_id
        ];
        return view('user.branch.index', $data);
    }

    public function branchVisits($branchId)
    {

        $branch = Branch::where('branch_uid','=',$branchId)->first();
        $branchId = $branch->id;
        $branch_list = Branch::all();
        $questionnaires_list = Questionnaire::all();
        $visitors_list = User::all();

        // Available visits: OPEN status AND user has NOT expressed interest
        $available_visits = $branch->visits()
            ->where('status','=',VisitStatus::OPEN->value)
            ->whereDoesntHave('interests', function($query) {
                $query->where('user_id', $this->user_id);
            })
            ->get();
            
        // Interested visits: where this user has expressed interest (from visit_interests table)
        $interested_visits = Visit::where('branch_id', $branchId)
            ->whereHas('interests', function($query) {
                $query->where('user_id', $this->user_id);
            })
            ->get();
            
        $scheduled_visits = $branch->visits()->where('visitor_id','=',$this->user_id)->where(function($query) {
            $query->where('status','=', VisitStatus::IN_PROGRESS->value)
                ->orWhere('status','=', VisitStatus::SCHEDULED->value)
                ->orWhere('status','=', VisitStatus::ASSIGNED->value);
        })->get();
        $pending_visits = $branch->visits()->where('visitor_id','=',$this->user_id)->where('status','=',VisitStatus::PENDING->value)->get();
        $completed_visits = $branch->visits()->where('visitor_id','=',$this->user_id)->where('status','=',VisitStatus::COMPLETED->value)->get();

        $data = [
            'branch' => $branch,
            'branchId' => $branchId,
            'branch_list' => $branch_list,
            'questionnaires_list' => $questionnaires_list,
            'visitors_list' => $visitors_list,
            'available_visits' => $available_visits,
            'interested_visits' => $interested_visits,
            'scheduled_visits' => $scheduled_visits,
            'pending_visits' => $pending_visits,
            'completed_visits' => $completed_visits,
        ];

        return view('user.branch.visit',$data);
    }

    public function branchVisitsList($branchId)
    {
        try {
            $query = Company::query();

            //  Sorting
            if (!empty($request->sort_by)) {
                switch ($request->sort_by) {
                    case 'name_asc':
                        $query->orderBy('company_name', 'asc');
                        break;
                    case 'name_desc':
                        $query->orderBy('company_name', 'desc');
                        break;
                }
            }

            $resultData = $query->get();
            $html = view('user.branch.visit-list', compact('resultData'))->render();
            return $this->sendSuccess($html);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }
}
