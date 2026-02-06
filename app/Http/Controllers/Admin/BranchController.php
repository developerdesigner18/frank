<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BranchContactStatus;
use App\Enums\BranchStatus;
use App\Enums\ReportStatus;
use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Branch;
use App\Models\Company;
use App\Models\BranchContact;
use App\Models\Questionnaire;
use App\Models\User;
use App\Models\Visit;
use App\Models\VisitReport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class BranchController extends Controller
{
    use ResponseTrait;

    public function index($companyId)
    {
        $company = Company::where('company_id','=',$companyId)->first();
        $companyId = $company->id;
        $subdealers = \App\Models\Subdealer::all();
        return view('admin.branch.index', compact('companyId','company','subdealers'));
    }


    public function branchList(Request $request, $companyId)
    {
        try {
            $query = Branch::query();
            $query->where('company_id', $companyId);

            // ✅ Filter by status
            if (!empty($request->status)) {
                $query->where('status', $request->status);
            }

            // ✅ Sorting
            if (!empty($request->sort_by)) {
                switch ($request->sort_by) {
                    case 'id_asc':
                        $query->orderBy('id', 'asc');
                        break;
                    case 'id_desc':
                        $query->orderBy('id', 'desc');
                        break;
                    case 'name_asc':
                        $query->orderBy('branch_name', 'asc');
                        break;
                    case 'name_desc':
                        $query->orderBy('branch_name', 'desc');
                        break;
                }
            }else{
                $query->orderBy('id', 'asc');
            }

            $resultData = $query->get();
            $html = view('admin.branch.list', compact('resultData'))->render();
            return $this->sendSuccess($html);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function addBranch(Request $request, $companyId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'branch_name' => ['required', 'string', 'max:255'],
                'image' => ['nullable', 'image'],
                'subdealer_id' => ['nullable'],
                'address_1' => ['nullable'],
                'locality' => ['nullable'],
                'postal_code' => ['nullable'],
                'upselling_input_url' => ['nullable'],
                'upselling_report_url' => ['nullable'],
                'input_url_46' => ['nullable'],
                'report_url_46' => ['nullable'],
                'route' => ['nullable'],
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            do {
                $unioqid = (string) Str::uuid();
            } while (Branch::where('branch_uid', $unioqid)->exists());

            $company = new Branch();
            $company->branch_uid = $unioqid;
            $company->company_id = $companyId;
            $company->subdealer_id = $request->subdealer_id;
            $company->branch_name = $request->branch_name;
            $company->status = BranchStatus::ACTIVE;
            $company->address_1 = $request->address_1;
            $company->locality = $request->locality;
            $company->postal_code = $request->postal_code;
            $company->upselling_input_url = $request->upselling_input_url;
            $company->upselling_report_url = $request->upselling_report_url;
            $company->input_url_46 = $request->input_url_46;
            $company->report_url_46 = $request->report_url_46;
            $company->route = $request->route;

            if ($request->hasFile('image')) {
                $file = uploadFile($request->image, COMPANY_BRANCH_PROFILE_IMAGE_PATH, 'branch_');
                $company->image = $file;
            }

            $company->save();

            return $this->sendSuccess("Branch has been added successfully");

        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function editBranch(Request $request, $companyId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => ['required', Rule::exists('branches', 'id')],
            ]);
            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $response = Branch::where('company_id', $companyId)->where('id', $request->id)->first();
            if ($response) {
                return $this->sendResponse("Branch details", $response);
            }
            return $this->sendError("Branch not found");

        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function updateBranch(Request $request, $companyId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => ['required', Rule::exists('branches', 'id')],
                'branch_name' => ['required', 'string', 'max:255'],
                'image' => ['nullable', 'image'],
                'subdealer_id' => ['nullable'],
                'address_1' => ['nullable'],
                'locality' => ['nullable'],
                'postal_code' => ['nullable'],
                'upselling_input_url' => ['nullable'],
                'upselling_report_url' => ['nullable'],
                'input_url_46' => ['nullable'],
                'report_url_46' => ['nullable'],
                'route' => ['nullable'],
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $company = Branch::find($request->id);
            $company->branch_name = $request->branch_name;
            $company->subdealer_id = $request->subdealer_id;

            if(!$company->branch_uid){
                $company->branch_uid = (string) Str::uuid();
            }

            if($request->status){
                $company->status = BranchStatus::ACTIVE;
            }else{
                $company->status = BranchStatus::INACTIVE;
            }

            $company->address_1 = $request->address_1;
            $company->locality = $request->locality;
            $company->postal_code = $request->postal_code;
            $company->upselling_input_url = $request->upselling_input_url;
            $company->upselling_report_url = $request->upselling_report_url;
            $company->input_url_46 = $request->input_url_46;
            $company->report_url_46 = $request->report_url_46;
            $company->route = $request->route;

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($company->image) {
                    @unlink(public_path(COMPANY_BRANCH_PROFILE_IMAGE_PATH . basename($company->image)));
                }
                $file = uploadFile($request->image, COMPANY_BRANCH_PROFILE_IMAGE_PATH, 'branch_');
                $company->image = $file;
            }

            $company->save();

            return $this->sendSuccess("Branch has been updated successfully");

        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function listBranchContact(Request $request, String $companyId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => ['required', Rule::exists('branches', 'id')],
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $resultData = BranchContact::where('branch_id', $request->id)->get();
            $html = view('admin.branch.contact_person_list', compact('resultData'))->render();

            return $this->sendResponse('',['html'=>$html,'branch_id'=>$request->id]);
        } catch (\Exception $exception) {
            return $this->sendDataTableError(ERROR_500, [], 500);
        }
    }

    public function addBranchContact(Request $request, $companyId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'branch_id' => ['required', Rule::exists('branches', 'id')],
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email'],
                'mobile_number' => ['required']
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $companyUser = new BranchContact();
            $companyUser->branch_id = $request->branch_id;
            $companyUser->first_name = $request->first_name;
            $companyUser->last_name = $request->last_name;
            $companyUser->email = $request->email;
            $companyUser->mobile_number = $request->mobile_number;
            $companyUser->status = BranchContactStatus::ACTIVE;
            $companyUser->save();

            return $this->sendSuccess("Branch contact has been added successfully");

        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function editBranchContact(Request $request, $companyId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => ['required', Rule::exists('branch_contacts', 'id')],
            ]);
            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $response = BranchContact::where('id', $request->id)->first();
            if ($response) {
                return $this->sendResponse("Branch User details", $response);
            }
            return $this->sendError("Branch contact not found");

        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function updateBranchContact(Request $request, $companyId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => ['required', Rule::exists('branch_contacts', 'id')],
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email'],
                'mobile_number' => ['required'],
//                'status' => ['required', Rule::in(array_column(BranchContactStatus::cases(), 'value'))]
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $companyUser = BranchContact::find($request->id);
            $companyUser->first_name = $request->first_name;
            $companyUser->last_name = $request->last_name;
            $companyUser->email = $request->email;
            $companyUser->mobile_number = $request->mobile_number;
//            $companyUser->status = BranchContactStatus::from($request->status);
            $companyUser->save();

            return $this->sendSuccess("Branch contact has been updated successfully");

        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    /*public function listBranch(Request $request, $companyId)
    {
        try {
            $response = Branch::query()->where('company_id', $companyId)->latest();

            return DataTables::eloquent($response)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return '<img src="' . $row->image . '" class="rounded avatar-sm" alt="Branch Logo">';
                })
                ->addColumn('status', function ($row) {
                    $statusOptions = '';
                    foreach (BranchStatus::cases() as $status) {
                        $selected = $row->status->value === $status->value ? 'selected' : '';
                        $statusOptions .= '<option value="' . $status->value . '" ' . $selected . '>' . $status->value . '</option>';
                    }
                    return '<select class="form-select status-select form-select-sm" data-id="' . $row->id . '">' . $statusOptions . '</select>';
                })
                ->addColumn('created_at', function ($row) {
                    return dateToHuman($row->created_at, 'd M Y');
                })
                ->addColumn('company_name', function ($row) {
                    return $row->company->company_name;
                })
                ->addColumn('action', function ($row) {
                    return '<ul class="list-inline mb-0 d-flex justify-content-center text-center">
                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Users">
                                <button type="button" onclick="showContacts(' . $row->id . ', \'' . addslashes($row->branch_name) . '\')" class="btn btn-outline-primary btn-icon waves-effect waves-light material-shadow-none">
                                    <i class="ri-user-fill fs-16"></i>
                                </button>
                            </li>
                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                <button type="button" onclick="getBranch(' . $row->id . ',this)" class="btn btn-outline-info btn-icon waves-effect waves-light material-shadow-none">
                                    <i class="ri-pencil-fill fs-16"></i>
                                </button>
                            </li>
                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                <button type="button" onclick="removeBranch(' . $row->id . ',this)" class="btn btn-outline-danger btn-icon waves-effect waves-light material-shadow-none">
                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                </button>
                            </li>
                        </ul>';
                })
                ->rawColumns(['action', 'status', 'image'])
                ->make(true);

        } catch (\Exception $exception) {
            return $this->sendDataTableError(ERROR_500, [], 500);
        }
    }*/

    public function updateBranchStatus(Request $request, $companyId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:branches,id',
                'status' => ['required', Rule::in(array_column(BranchStatus::cases(), 'value'))]
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $company = Branch::find($request->id);
            $company->status = BranchStatus::from($request->status);
            $company->save();

            return $this->sendSuccess("Branch status updated successfully");

        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function deleteBranch(Request $request, $companyId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:branches,id',
            ]);
            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $company = Branch::find($request->id);

            // Delete image if exists
            if ($company->image) {
                @unlink(public_path(COMPANY_BRANCH_PROFILE_IMAGE_PATH . $company->image));
            }

            $company->delete();

            return $this->sendSuccess("Branch has been removed successfully");

        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function updateBranchContactStatus(Request $request, $companyId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:branch_contacts,id',
                'status' => ['required', Rule::in(array_column(BranchContactStatus::cases(), 'value'))]
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $companyUser = BranchContact::find($request->id);
            $companyUser->status = BranchContactStatus::from($request->status);
            $companyUser->save();

            return $this->sendSuccess("Branch contact status updated successfully");

        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function deleteBranchContact(Request $request, $companyId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:branch_contacts,id',
            ]);
            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $companyUser = BranchContact::find($request->id);
            $companyUser->delete();

            return $this->sendSuccess("Branch contact has been removed successfully");

        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }


//    ========= Branch Visits
    public function branchVisits($branchId)
    {
        $branch = Branch::where('branch_uid','=',$branchId)->first();
        $branchId = $branch->id;
        $branch_list = Branch::all();
        $questionnaires_list = Questionnaire::all();
        $visitors_list = User::all();
        return view('admin.branch.visits', compact('branchId','branch','branch_list','questionnaires_list','visitors_list'));
    }

    public function branchVisitsList(Request $request, $branchId)
    {
        try {
            $query = Visit::query();
            $query->where('branch_id', $branchId);
            $query->orderBy('id', $request->sort_by??'asc');

            $resultData = $query->get();
            $html = view('admin.visit.list', compact('resultData'))->render();
            return $this->sendSuccess($html);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }


//    ========= visit Report
    public function visitReport($branchId)
    {
        $branch = Branch::where('branch_uid', $branchId)
            ->with('company')
            ->firstOrFail();

        return view('admin.branch.visit-reports',compact('branch',));
    }

    public function visitReportList(Request $request, $branchId)
    {
        try {

            $resultData = VisitReport::whereHas('visit', function ($query) use ($branchId) {
                    $query->where('branch_id', $branchId);
                })
                ->with('visit')
                ->where('status','=',ReportStatus::COMPLETED->value)
                ->orderBy('id', $request->sort_by??'asc')
            ->get();

            $html = view('admin.branch.visit-reports-list', compact('resultData', 'branchId'))->render();
            return $this->sendSuccess($html);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function visitSubmissions(STRING $reportId)
    {
        $visitReport = VisitReport::where('report_uid', $reportId)->firstOrFail();

        if(gettype($visitReport->response_data)=='array'){
            $response_data = $visitReport->response_data;
        }else{
            $response_data = json_decode($visitReport->response_data, true);
        }

        return view('admin.branch.view-submissions',compact('visitReport','response_data'));
    }

    public function visitCategory(String $reportId, String $categoryId)
    {
        $visitReport = VisitReport::where('report_uid', $reportId)->firstOrFail();

        if(gettype($visitReport->response_data)=='array'){
            $response_data = $visitReport->response_data;
        }else{
            $response_data = json_decode($visitReport->response_data, true);
        }
        $questions = $response_data['question'][$categoryId]??[];

        return view('admin.branch.visit-category',compact('visitReport','response_data', 'categoryId', 'questions'));
    }


}
