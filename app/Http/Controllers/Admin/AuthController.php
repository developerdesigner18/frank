<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ResponseTrait;

    public function login()
    {
        return view('admin.pages.login');
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

    public function updateName(Request $request)
    {
        try {
            if (Auth::user()->update(['name' => $request->name])) {
                return $this->sendSuccess("Name Updated Successfully");
            } else {
                return $this->sendError("Unable to update the name");
            }

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

            if (Hash::check($request->current_password, Auth::guard('admin')->user()->password)) {
                Auth::guard('admin')->user()->update(['password' => Hash::make($request->password)]);
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
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
