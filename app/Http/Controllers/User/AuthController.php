<?php

namespace App\Http\Controllers\User;

use App\Enums\RemunerationMethod;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;
class AuthController extends Controller
{
    use ResponseTrait;

    public function login()
    {
        return view('user.pages.login');
    }

    public function loginCheck(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $rememberToken = $request->has('remember_me');

        if (Auth::guard('web')->attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ], $rememberToken)) {
            return $this->sendSuccess('Login successful');
        } else {
            return $this->sendError('Invalid email or password');
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

        if (Auth::guard('admin')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $rememberToken)) {
            return $this->sendSuccess('login successful');
        } else {
            return $this->sendError('Invalid email or password');
        }
    }


    public function checkInvitation(Request $request, $cryptToken)
    {
        $decrypt = Crypt::decrypt($cryptToken);

        $verifyInvitation = User::where('email', $decrypt)->where('status', UserStatus::INVITED)->first();

        if (!$verifyInvitation) {
            abort(403);
        }

        return view('user.pages.accept-invitation', compact('decrypt'));
    }

    public function register(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'cryptToken' => ['required'],
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed']
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $email = Crypt::decrypt($request->cryptToken);

//            Verify the CryptToken
            $getInvitation = User::where('email', $email)->where('status', UserStatus::INVITED->value)->first();

            if (!$getInvitation) {
                return $this->sendError('Something Went Wrong');
            }

            $getInvitation->first_name = $request->first_name;
            $getInvitation->last_name = $request->last_name;
            $getInvitation->password = Hash::make($request->password);
            $getInvitation->status = UserStatus::ACTIVE->value;
            $getInvitation->mobile_number = $request->mobile_number;
            $getInvitation->remuneration_method = $request->remuneration_method;
            $getInvitation->receive_visit_emails = $request->receive_new_visit_emails;

            if ($request->hasFile('image')) {
                $file = uploadFile($request->image, USER_PROFILE_IMAGE_PATH, 'user_');
                $getInvitation->profile_image = $file;
            }
            $getInvitation->email_verified_at = now();
            $getInvitation->save();

            return $this->sendSuccess("Registered Successfully!");

        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function updateName(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'mobile_number' => ['nullable'],
                'remuneration_method' => ['nullable', new Enum(RemunerationMethod::class)]
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $user = Auth::guard('web')->user();
            $user->fill($request->only('first_name', 'last_name','bank_account', 'mobile_number', 'remuneration_method'));
            $user->save();


            if ($request->hasFile('image')) {
                if ($user->profile_image) {
                    @unlink(public_path(USER_PROFILE_IMAGE_PATH . basename($user->profile_image)));
                }
                $file = uploadFile($request->image, USER_PROFILE_IMAGE_PATH, 'user_');
                $user->update(['profile_image' => $file]);
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
                'new_password' =>

              [ 'required'
//               Password::min(8)
//                  ->mixedCase()
//                   ->letters()
//                    ->numbers()
//                   ->symbols()
          ],
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            if ($request->current_password == $request->new_password) {
                return $this->sendError("Your current password and new password are same");
            }

            if (Hash::check($request->current_password, Auth::guard('web')->user()->password)) {
                Auth::guard('web')->user()->update(['password' => Hash::make($request->password)]);
                return $this->sendSuccess("Password updated successful!");
            } else {
                return $this->sendError("Current password is wrong!");
            }

        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }
}
