<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FaqAnswer;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\ResponseTrait;

class SettingController extends Controller
{
    use ResponseTrait;

    // 🔧 Constructor Function
    public function __construct()
    {
        $this->userData = Auth::guard('web')->user();
        $this->user_id = Auth::guard('web')->user()->id;
    }

    public function index()
    {
        return view('user.pages.settings');
    }

    public function profile()
    {
        return view('user.pages.profile');
    }

    public function changePassword()
    {
        return view('user.pages.change-password');
    }

    public function profileUpdate(Request $request)
    {
        try {
            $user = auth('web')->user(); // Get currently authenticated user

            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',

                'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // 2MB max

            ], [
                'profile_image.max' => "Image size maximum 2MB"
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }
            // Update fields
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->bank_account = $request->bank_account_code;
            $user->mobile_number = $request->phone;
            $user->remuneration_method = $request->remuneration;
            $user->receive_visit_emails = $request->has('receive_new_visit_emails') ? 1 : 0;
            if ($request->hasFile('profile_image')) {

                $file = uploadFile($request->profile_image, USER_PROFILE_IMAGE_PATH, 'user_');
                $user->profile_image = $file;
            }
            $user->save();
            return $this->sendSuccess("Profile Update Successfully!");

        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function activityLog()
    {
        return view('user.pages.activity-logs');
    }

    public function contactSupport()
    {
        return view('user.pages.contact-support');
    }

    public function faq()
    {
        $resultData = Setting::where('type','=','visitor_faq')->first();
        $resultData = $resultData ? json_decode($resultData->value, true):[];
        $user_id = $this->user_id;
        return view('user.pages.faq', compact('resultData','user_id'));
    }
    public function faqAction(Request $request)
    {
        try {
            dd($request->answer);
            $visitor_qus = $request->visitor_qus;

            $answer = [];
            if($visitor_qus){
                foreach ($visitor_qus as $vk => $vqus){
                    if($vqus){
                        $answer[$vqus] = $request->visitor_ans[$vk];
                    }
                }
            }

            $faq = FaqAnswer::updateOrCreate(
                ['user_id' => $this->user_id], // condition
                ['answer' => json_encode($request->answer)] // data to update/insert
            );

            if ($faq) {
                return $this->sendSuccess("FAQ Details Updated Successfully!");
            } else {
                return $this->sendError("Unable to update the FAQ.");
            }

        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

}
