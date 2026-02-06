<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RemunerationMethod;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Mail\VisitorInvitationMail;
use App\Models\Branch;
use App\Models\EmailTemplate;
use App\Models\Questionnaire;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class MysteryVisitorController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        return view('admin.visitor.index');
    }

    public function listVisitor(Request $request)
    {
        try {
            $query = User::query();

            // ✅ Search filter
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($query) use ($search){
                    $query->where('first_name', 'like', "%{$search}%") // fix column name
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
                });
            }

            // ✅ Filter by status
            if ($request->status) {
                $query->where('status', $request->status);
            }

            // ✅ Sorting
            if (!empty($request->sort_by)) {
                switch ($request->sort_by) {
                    case 'first_name_asc':
                        $query->orderBy('first_name', 'asc');
                        break;
                    case 'first_name_desc':
                        $query->orderBy('first_name', 'desc');
                        break;
                    case 'last_name_asc':
                        $query->orderBy('last_name', 'asc');
                        break;
                    case 'last_name_desc':
                        $query->orderBy('last_name', 'desc');
                        break;
                }
            }else{
                $query->orderBy('id', 'asc');
            }

            $resultData = $query->get();
            $html = view('admin.visitor.list', compact('resultData'))->render();
            return $this->sendSuccess($html);
        } catch (\Exception $exception) {
            return $this->sendDataTableError(ERROR_500, [], 500);
        }
    }

    public function addVisitor(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->where('status', UserStatus::ACTIVE->value)->whereNull('deleted_at')],
                'password' => ['required', 'string', 'min:8'],
                'image' => ['nullable', 'image'],
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $visitor = new User();
            $visitor->first_name = $request->first_name;
            $visitor->last_name = $request->last_name;
            $visitor->email = $request->email;
            $visitor->password = Hash::make($request->password);
            $visitor->status = UserStatus::ACTIVE;

            if ($request->hasFile('image')) {
                $file = uploadFile($request->image, USER_PROFILE_IMAGE_PATH, 'user_');
                $visitor->profile_image = $file;
            }

            $visitor->save();

            return $this->sendSuccess("User has been added successfully");

        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function inviteVisitor(Request $request)
    {

        try {
            if (!$request->id){
                $validator = Validator::make($request->all(), [
                    'invitation_email' => ['required', 'string', 'email', 'max:255', Rule::unique('users','email')->where(function ($q) {
                        $q->where('status', UserStatus::ACTIVE->value)->orWhere('status', UserStatus::INVITED->value);
                    })->whereNull('deleted_at')],
                ]);

                if ($validator->fails()) {
                    return $this->sendValidationError($validator->errors());
                }
            }

            DB::beginTransaction();
            do {
                $uuid = (string) Str::uuid();
            } while (User::where('uid', $uuid)->exists());

            $visitor = new User();
            $visitor->uid = $uuid;
            $visitor->email = $request->invitation_email;
            $visitor->status = UserStatus::INVITED;
            if (!$request->id) {
                $visitor->save();
            }

            $cryptMail = Crypt::encrypt($request->invitation_email);
            $template = EmailTemplate::where('slug', 'visitor_invitation')->first();

            $mail=Mail::to($visitor->email)->send(new VisitorInvitationMail($cryptMail, $template, $visitor));


            DB::commit();
            return $this->sendSuccess("Invitation link has been sent");

        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function editVisitor(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => ['required', Rule::exists('users', 'id')],
            ]);
            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $response = User::where('id', $request->id)->first();
            if ($response) {
                return $this->sendResponse("User details", $response);
            }
            return $this->sendError("User not found");

        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function updateVisitor(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => ['required', Rule::exists('users', 'id')],
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'image' => ['nullable', 'image'],
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $visitor = User::find($request->id);
            if(!$visitor->uid){
                $visitor->uid = (string) Str::uuid();
            }
            $visitor->first_name = $request->first_name;
            $visitor->last_name = $request->last_name;
            $visitor->bank_account = $request->bank_account;

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($visitor->profile_image) {
                    @unlink(public_path(USER_PROFILE_IMAGE_PATH . basename($visitor->profile_image)));
                }
                $file = uploadFile($request->image, USER_PROFILE_IMAGE_PATH, 'company_');
                $visitor->profile_image = $file;
            }

            $visitor->save();

            return $this->sendSuccess("User has been updated successfully");

        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:users,id',
                'status' => ['required', Rule::in(array_column(UserStatus::cases(), 'value'))]
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $visitor = User::find($request->id);
            $visitor->status = UserStatus::from($request->status);
            $visitor->save();

            return $this->sendSuccess("User status updated successfully");

        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function updateMethod(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:users,id',
                'remuneration_method' => ['nullable', Rule::in(array_column(RemunerationMethod::cases(), 'value'))]
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $visitor = User::find($request->id);
            $visitor->remuneration_method = $request->remuneration_method ? RemunerationMethod::from($request->remuneration_method) : null;
            $visitor->save();

            return $this->sendSuccess("User method updated successfully");

        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function deleteVisitor(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:users,id',
            ]);
            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $visitor = User::find($request->id);

            $visitor->delete();

            return $this->sendSuccess("User has been removed successfully");

        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function visits($visitorId)
    {
        $user = User::where('uid','=',$visitorId)->first();
        $visitorId = $user->id;
        $branch_list = Branch::all();
        $questionnaires_list = Questionnaire::all();
        $visitors_list = User::all();
        return view('admin.visitor.visits', compact('visitorId','user','branch_list','questionnaires_list','visitors_list'));
    }

    public function visitsList(Request $request, $visitorId)
    {
        try {
            $query = Visit::query();
            $query->where('visitor_id', $visitorId);
            $query->orderBy('id', $request->sort_by??'asc');

            $resultData = $query->get();
            $html = view('admin.visit.list', compact('resultData'))->render();
            return $this->sendSuccess($html);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }
}
