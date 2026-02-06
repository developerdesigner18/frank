<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CompanyStatus;
use App\Enums\CompanyUserStatus;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Mail\CompanyUserInvitationMail;
use App\Mail\VisitorInvitationMail;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\Subdealer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $subdealers=Subdealer::all();
        return view('admin.company.index',compact('subdealers'));
    }

    public function companyList(Request $request)
    {
        try {
            $query = Company::query();

            // ✅ Filter by status
            if (!empty($request->status)) {
                $query->where('status', $request->status);
            }

            // ✅ Search filter
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('company_name', 'like', "%{$search}%");
            }
//dd($request->sort_by);
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
                        $query->orderBy('company_name', 'asc');
                        break;
                    case 'name_desc':
                        $query->orderBy('company_name', 'desc');
                        break;
                }
            }

            $resultData = $query->get();
            $html = view('admin.company.company_list', compact('resultData'))->render();
            return $this->sendSuccess($html);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function addCompany(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'company_name' => ['required', 'string', 'max:255'],
                'image' => ['nullable', 'image'],
                'subdealer_id'=>['nullable']
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $company = new Company();
            $company->company_id = (string) Str::uuid();
            $company->company_name = $request->company_name;
            $company->subdealer_id =$request->subdealer_id;
            $company->status = CompanyStatus::ACTIVE;


            if ($request->hasFile('image')) {
                $file = uploadFile($request->image, COMPANY_PROFILE_IMAGE_PATH, 'company_');
                $company->image = $file;
            }

            $company->save();

            return $this->sendSuccess("Company has been added successfully");

        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function editCompany(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => ['required', Rule::exists('companies', 'id')],
            ]);
            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $response = Company::where('id', $request->id)->first();


            if ($response) {
                return $this->sendResponse("Company details", $response);
            }
            return $this->sendError("Company not found");

        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function updateCompany(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => ['required', Rule::exists('companies', 'id')],
                'company_name' => ['required', 'string', 'max:255'],
                'image' => ['nullable', 'image'],
                'subdealer_id'=>['nullable']
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }
            $company = Company::find($request->id);
            if(!$company->company_id){
                $company->company_id = (string) Str::uuid();
            }

            if($request->subdealer_id){
                $company->subdealer_id = $request->subdealer_id;
            }
            $company->company_name = $request->company_name;
            if($request->status){
                $company->status = CompanyStatus::ACTIVE;
            }else{
                $company->status = CompanyStatus::DEACTIVATE;
            }

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($company->image) {
                    @unlink(public_path(COMPANY_PROFILE_IMAGE_PATH . basename($company->image)));
                }
                $file = uploadFile($request->image, COMPANY_PROFILE_IMAGE_PATH, 'company_');
                $company->image = $file;
            }

            $company->save();

            return $this->sendSuccess("Company has been updated successfully");

        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:companies,id',
                'status' => ['required', Rule::in(array_column(CompanyStatus::cases(), 'value'))]
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $company = Company::find($request->id);
            $company->status = CompanyStatus::from($request->status);
            $company->save();

            return $this->sendSuccess("Company status updated successfully");

        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function deleteCompany(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:companies,id',
            ]);
            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $company = Company::find($request->id);

            // Delete image if exists
            if ($company->image) {
                @unlink(public_path(COMPANY_PROFILE_IMAGE_PATH . $company->image));
            }

            $company->delete();

            return $this->sendSuccess("Company has been removed successfully");

        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function listCompanyUsers(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'company_id' => ['required', Rule::exists('companies', 'id')],
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $resultData = CompanyUser::where('company_id', $request->company_id)->get();

            $html = view('admin.company.invite_admin_list', compact('resultData'))->render();

            return $this->sendResponse('',['html'=>$html,'company_id'=>$request->company_id]);
        } catch (\Exception $exception) {
            return $this->sendDataTableError(ERROR_500, [], 500);
        }
    }

    public function addCompanyUser(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'company_id' => ['required', Rule::exists('companies', 'id')],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:company_users,email'],
                'password' => ['required', 'string', 'min:8'],
                'image' => ['nullable', 'image'],
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $companyUser = new CompanyUser();
            $companyUser->company_id = $request->company_id;
            $companyUser->name = $request->name;
            $companyUser->email = $request->email;
            $companyUser->password = Hash::make($request->password);
            $companyUser->status = CompanyUserStatus::ACTIVE;

            if ($request->hasFile('image')) {
                $file = uploadFile($request->image, COMPANY_USER_PROFILE_IMAGE_PATH, 'company_user_');
                $companyUser->image = $file;
            }

            $companyUser->save();

            return $this->sendSuccess("Company user has been added successfully");

        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function editCompanyUser(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => ['required', Rule::exists('company_users', 'id')],
            ]);
            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $response = CompanyUser::where('id', $request->id)->first();
            if ($response) {
                return $this->sendResponse("Company user details", $response);
            }
            return $this->sendError("Company user not found");

        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function updateCompanyUser(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => ['required', Rule::exists('company_users', 'id')],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', Rule::unique('company_users', 'email')->ignore($request->id)],
                'password' => ['nullable', 'string', 'min:8'],
                'image' => ['nullable', 'image'],
                'mobile_number' => ['nullable'],
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $companyUser = CompanyUser::find($request->id);
            $companyUser->name = $request->name;
            $companyUser->email = $request->email;
            $companyUser->mobile_number = $request->mobile_number;
            $companyUser->status = CompanyUserStatus::ACTIVE->value;

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($companyUser->image) {
                    @unlink(public_path(COMPANY_USER_PROFILE_IMAGE_PATH . basename($companyUser->image)));
                }
                $file = uploadFile($request->image, COMPANY_USER_PROFILE_IMAGE_PATH, 'company_user_');
                $companyUser->image = $file;
            }

            $companyUser->save();

            return $this->sendSuccess("Company user has been updated successfully");

        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function updateCompanyUserStatus(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:company_users,id',
                'status' => ['required', Rule::in(array_column(CompanyUserStatus::cases(), 'value'))]
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $companyUser = CompanyUser::find($request->id);
            $companyUser->status = CompanyUserStatus::from($request->status);
            $companyUser->save();

            return $this->sendSuccess("Company user status updated successfully");

        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function deleteCompanyUser(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:company_users,id',
            ]);
            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $companyUser = CompanyUser::find($request->id);

            // Delete image if exists
            if ($companyUser->image) {
                @unlink(public_path(COMPANY_USER_PROFILE_IMAGE_PATH . $companyUser->image));
            }

            $companyUser->delete();

            return $this->sendSuccess("Company user has been removed successfully");

        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function inviteUser(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'company_id' => ['required', Rule::exists('companies', 'id')],
                'invitation_email' => ['required', 'string', 'email', 'max:255', Rule::unique('company_users', 'email')->where('company_id', $request->company_id)->where(function ($q) {
                    $q->where('status', CompanyUserStatus::ACTIVE->value)->orWhere('status', CompanyUserStatus::INVITED->value);
                })->whereNull('deleted_at')],
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            DB::beginTransaction();
            $visitor = new CompanyUser();
            $visitor->email = $request->invitation_email;
            $visitor->company_id = $request->company_id;
            $visitor->status = CompanyUserStatus::INVITED;
            $visitor->save();

            $company = $visitor->company;

            $cryptMail = Crypt::encrypt($request->invitation_email);

//            Mail::to($visitor->email)->send(new CompanyUserInvitationMail($cryptMail, $company));
            Mail::to($visitor->email)->send(new CompanyUserInvitationMail($cryptMail, $company, $visitor));

            DB::commit();
            return $this->sendSuccess("Invitation link has been sent");

        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function reInviteUser(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'invitation_email' => ['required', 'string', 'email', 'max:255'],
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            DB::beginTransaction();
            $visitor = CompanyUser::find($request->id);

            $company = $visitor->company;

            $cryptMail = Crypt::encrypt($request->invitation_email);

//            Mail::to($visitor->email)->send(new CompanyUserInvitationMail($cryptMail, $company));
            Mail::to($visitor->email)->send(new CompanyUserInvitationMail($cryptMail, $company, $visitor));

            DB::commit();
            return $this->sendSuccess("Invitation link has been sent");

        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError($exception->getMessage(), 500);
        }
    }

}
