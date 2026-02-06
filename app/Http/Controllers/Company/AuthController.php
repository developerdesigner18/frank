<?php

namespace App\Http\Controllers\Company;

use App\Enums\CompanyUserStatus;
use App\Enums\RemunerationMethod;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\CompanyUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class AuthController extends Controller
{
    use ResponseTrait;

    public function login()
    {
        return view('company.pages.login');
    }

    public function updateName(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $user = Auth::guard('company')->user();
            $user->fill($request->only('name'));
            $user->save();


            if ($request->hasFile('image')) {
                if ($user->image) {
                    @unlink(public_path(USER_PROFILE_IMAGE_PATH . basename($user->image)));
                }
                $file = uploadFile($request->image, COMPANY_USER_PROFILE_IMAGE_PATH, 'company_user_');
                $user->update(['image' => $file]);
            }


            return $this->sendSuccess("Profile Updated Successfully!");

        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function updatePassword(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'current_password' => 'required',
                'password' => 'required|confirmed',
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            if ($request->current_password == $request->password) {
                return $this->sendError("Your current password and new password are same");
            }

            if (Hash::check($request->current_password, Auth::guard('company')->user()->password)) {
                Auth::guard('company')->user()->update(['password' => Hash::make($request->password)]);
                return $this->sendSuccess("Password updated successful!");
            } else {
                return $this->sendError("Current password is wrong!");
            }

        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function loginAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $rememberToken = $request->has('remember_me') ? true : false;

//        TODO : check for multiple company and login.

        if (Auth::guard('company')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $rememberToken)) {
            return $this->sendSuccess('login successful');
        } else {
            return $this->sendError('Invalid email or password');
        }
    }

    public function logout()
    {
        Auth::guard('company')->logout();
        return redirect()->route('company.login');
    }

    public function checkInvitation(Request $request, $cryptToken)
    {
        $decrypt = Crypt::decrypt($cryptToken);

        $verifyInvitation = CompanyUser::where('email', $decrypt)->where('status', CompanyUserStatus::INVITED)->first();

        if (!$verifyInvitation) {
            abort(403);
        }

        return view('company.pages.accept-invitation', compact('decrypt'));
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'cryptToken' => ['required'],
                'name' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed']
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $email = Crypt::decrypt($request->cryptToken);

//            Verify the CryptToken
            $getInvitation = CompanyUser::where('email', $email)->where('status', CompanyUserStatus::INVITED->value)->first();

            if (!$getInvitation) {
                return $this->sendError('Something Went Wrong');
            }

            $getInvitation->name = $request->name;
            $getInvitation->password = Hash::make($request->password);
            $getInvitation->status = UserStatus::ACTIVE->value;

            if ($request->hasFile('image')) {
                $file = uploadFile($request->image, COMPANY_USER_PROFILE_IMAGE_PATH, 'company_user_');
                $getInvitation->image = $file;
            }
            $getInvitation->email_verified_at = now();

            $getInvitation->save();

            return $this->sendSuccess("Registered Successfully!");

        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function switchProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:company_users,id'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        try {

            Auth::guard('company')->loginUsingId($request->id);

            return $this->sendSuccess('success');
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }
    }
}
