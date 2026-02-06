<?php

namespace App\Http\Controllers\User;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Mail\ForgotPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ForgotPasswordController extends Controller
{
    use ResponseTrait;

    public function showForgetPasswordForm()
    {
        return view('user.pages.forgot-password');
    }

    public function submitForgetPasswordForm(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', Rule::exists('users', 'email')->where(function ($q) {
                $q->where('status', UserStatus::ACTIVE->value);
            })->whereNull('deleted_at')],
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        try {
            $token = Str::random(64);

            DB::table('password_reset_tokens')->updateOrInsert([
                'email' => $request->email,
                'guard' => 'web',
            ], [
                'email' => $request->email,
                'token' => $token,
                'guard' => 'web',
                'created_at' => Carbon::now()
            ]);

            $user = User::where('email', $request->email)->where('status', UserStatus::ACTIVE->value)->first();
    ;
            $resetLink = route('reset.password.get', ['token' => $token]);

            Mail::to($request->email)->send(new ForgotPasswordMail($user, $resetLink));

            return $this->sendSuccess('We have e-mailed your password reset link!');
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }

    }

    public function showResetPasswordForm($token)
    {
        // Check if the token exists in the database
        $checkToken = DB::table('password_reset_tokens')
            ->where([
                'token' => $token,
                'guard' => 'web',
            ])
            ->first(); // execute the query

        // If token doesn't exist, redirect to login
        if (!$checkToken) {
            return redirect()->route('login'); // make sure you have a named route 'login'
        }

        // If token exists, show the reset password form
        return view('user.pages.reset-password', ['token' => $token]);
    }

    public function showSuccessPageForm()
    {
        return view('user.pages.mail-sent-success');
    }

    public function submitResetPasswordForm(Request $request)
    {
//        $validator = Validator::make($request->all(), [
//            'token' => 'required',
//            'password' => 'required|string|confirmed',
//        ]);
//
//        if ($validator->fails()) {
//            return $this->sendValidationError($validator->errors());
//        }
//        try {
//            DB::beginTransaction();
//
//            $updatePassword = DB::table('password_reset_tokens')
//                ->where([
//                    'token' => $request->token,
//                    'guard' => 'web',
//                ])
//                ->first();
//
//            if (!$updatePassword) {
//                return back()->withInput()->with('error', 'Invalid token!');
//            }
//
//            User::where('email', $updatePassword->email)
//                ->update(['password' => Hash::make($request->password)]);
//
//            DB::table('password_reset_tokens')->where(['token' => $request->token, 'guard' => 'web'])->delete();
//
//
//            DB::commit();
//            return $this->sendSuccess('Your password has been changed!');
//        } catch (\Exception $exception) {
//            DB::rollBack();
//            return $this->sendError($exception->getMessage());
//        }
        $validator = Validator::make($request->all(), [
            'token' => 'required',
//            'password' => [
//                'required',
//                Password::min(8)
//                    ->mixedCase()
//                    ->letters()
//                    ->numbers()
//                    ->symbols()
//            ],
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }
        try {
            DB::beginTransaction();

            $updatePassword = DB::table('password_reset_tokens')
                ->where([
                    'token' => $request->token,
                    'guard' => 'web',
                ])
                ->first();

            if (!$updatePassword) {
                return $this->sendError('Invalid Token!');
            }

            User::where('email', $updatePassword->email)
                ->update(['password' => Hash::make($request->password)]);

            DB::table('password_reset_tokens')->where(['token' => $request->token, 'guard' => 'web'])->delete();


            DB::commit();
            return $this->sendSuccess('Your password has been changed!');
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError($exception->getMessage());
        }
    }
}
