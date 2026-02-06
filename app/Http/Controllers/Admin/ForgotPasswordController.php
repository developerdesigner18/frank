<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Mail\ForgotPasswordMail;
use App\Models\Admin;
use App\Models\CompanyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ForgotPasswordController extends Controller
{
    use ResponseTrait;

    public function showForgetPasswordForm()
    {
        return view('admin.pages.forgot-password');
    }

    public function submitForgetPasswordForm(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', Rule::exists('admins', 'email')->whereNull('deleted_at')],
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        try {
            $token = Str::random(64);

            DB::table('password_reset_tokens')->updateOrInsert([
                'email' => $request->email,
                'guard' => 'admin',
            ], [
                'email' => $request->email,
                'token' => $token,
                'guard' => 'admin',
                'created_at' => Carbon::now()
            ]);


            $user = Admin::where('email', $request->email)->first();
            $resetLink = route('admin.reset.password.get', ['token' => $token]);

            Mail::to($request->email)->send(new ForgotPasswordMail($user, $resetLink));

            return $this->sendSuccess('We have e-mailed your password reset link!');
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }

    }

    public function showResetPasswordForm($token)
    {
        return view('admin.pages.reset-password', ['token' => $token]);
    }

    public function showSuccessPageForm()
    {
        return view('admin.pages.mail-sent-success');
    }

    public function submitResetPasswordForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required|string|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }
        try {
            DB::beginTransaction();

            $updatePassword = DB::table('password_reset_tokens')
                ->where([
                    'token' => $request->token,
                    'guard' => 'admin',
                ])
                ->first();

            if (!$updatePassword) {
                return $this->sendError('Invalid Token!');
            }

            Admin::where('email', $updatePassword->email)
                ->update(['password' => Hash::make($request->password)]);

            DB::table('password_reset_tokens')->where(['token' => $request->token, 'guard' => 'admin'])->delete();


            DB::commit();
            return $this->sendSuccess('Your password has been changed!');
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError($exception->getMessage());
        }

    }
}
