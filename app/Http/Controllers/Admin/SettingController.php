<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $rowData = Auth::guard('admin')->user();
        $announcement = Setting::where('type','=','announcement')->first();
        $email_attachment_file = Setting::where('type','=','email_attachment_file')->first();
        return view('admin.settings.index', compact('rowData','announcement','email_attachment_file'));
    }

    public function accountUpdate(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'password' => 'nullable|confirmed',
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $admin = Auth::guard('admin')->user();

            $saveData = [
                'name' => $request->name
            ];
            $image = $admin->profile_img;
            if ($request->hasFile('profile_img')) {
                if ($admin->profile_img) {
                    deleteImage($admin->profile_img, ADMIN_PROFILE_IMAGE_PATH);
                }
                $file = uploadFile($request->profile_img, ADMIN_PROFILE_IMAGE_PATH);
                $saveData['profile_img'] = $file;
                $image = asset(ADMIN_PROFILE_IMAGE_PATH. $file);
            }
            if ($request->password){
                $saveData['password'] = Hash::make($request->password);
            }

            $admin = $admin->update($saveData);
            if ($admin) {
                return $this->sendResponse("Account Details Updated Successfully!",['name'=>$request->name,'image'=>$image]);
            } else {
                return $this->sendError("Unable to update the Account Details.");
            }

        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function announcementUpdate(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'announcement' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $admin = Setting::updateOrCreate(
                ['type' => 'announcement'], // condition
                ['value' => $request->announcement] // data to update/insert
            );
            if ($admin) {
                return $this->sendSuccess("Announcement Updated Successfully!");
            } else {
                return $this->sendError("Unable to update the Announcement.");
            }

        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function emailAttachmentUpdate(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'image' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $email_attachment_file = Setting::where('type','=','email_attachment_file')->first();

            if ($request->hasFile('image')) {
                if ( isset($email_attachment_file) && $email_attachment_file->value) {
                    deleteImage($email_attachment_file->value, SETTING_PATH);
                }
                $file = uploadFile($request->image, SETTING_PATH);

                $admin = Setting::updateOrCreate(
                    ['type' => 'email_attachment_file'], // condition
                    ['value' => $file] // data to update/insert
                );
                if ($admin) {
                    $email_attachment_file = Setting::where('type','=','email_attachment_file')->first();
                    return $this->sendResponse("Email Attachment Updated Successfully!",['image_path'=>asset(SETTING_PATH. $email_attachment_file->value), 'image'=>$email_attachment_file->value, 'id'=>$email_attachment_file->id]);
                } else {
                    return $this->sendError("Unable to update the Email Attachment.");
                }
            } else {
                return $this->sendError("Unable to update the Email Attachment.");
            }

        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function emailAttachmentDelete(Request $request)
    {
        try {
            DB::beginTransaction();

            $email_attachment_file = Setting::find($request->id);
            if ( isset($email_attachment_file) && $email_attachment_file->value) {
                deleteImage($email_attachment_file->value, SETTING_PATH);
            }
            $email_attachment_file->update(['value'=>null]);

            DB::commit();
            return $this->sendSuccess("file has been removed successfully!");
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function faq()
    {
        $rowData = Auth::guard('admin')->user();
        $visitor_faq = Setting::where('type','=','visitor_faq')->first();
        $visitor_faq = $visitor_faq ? json_decode($visitor_faq->value, true):[];
        $company_faq = Setting::where('type','=','company_faq')->first();
        $company_faq = $company_faq ? json_decode($company_faq->value, true):[];
        return view('admin.settings.faq', compact('rowData','visitor_faq', 'company_faq'));
    }
    public function faqAction(Request $request)
    {
        try {
            $visitor_qus = $request->visitor_qus;
            $company_qus = $request->company_qus;

            $visitor = [];
            if($visitor_qus){
                foreach ($visitor_qus as $vk => $vqus){
                    if($vqus){
                        $visitor[] = [
                            'question' => $vqus,
                            'answer' => $request->visitor_ans[$vk],
                        ];
                    }
                }
            }

            $faq = Setting::updateOrCreate(
                ['type' => 'visitor_faq'], // condition
                ['value' => json_encode($visitor)] // data to update/insert
            );

            $company = [];
            if($company_qus){
                foreach ($company_qus as $ck => $cqus){
                    if($cqus){
                        $company[] = [
                            'question' => $cqus,
                            'answer' => $request->company_ans[$ck],
                        ];
                    }
                }
            }

            $faq = Setting::updateOrCreate(
                ['type' => 'company_faq'], // condition
                ['value' => json_encode($company)] // data to update/insert
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

    public function guides()
    {
        $rowData = Auth::guard('admin')->user();
        $visitor_guides = Setting::where('type','=','visitor_guides')->first();
        $visitor_guides = $visitor_guides ? json_decode($visitor_guides->value, true):[];
        $company_guides = Setting::where('type','=','company_guides')->first();
        $company_guides = $company_guides ? json_decode($company_guides->value, true):[];
        return view('admin.settings.guides', compact('rowData','visitor_guides', 'company_guides'));
    }
    public function guidesAction(Request $request)
    {
        try {
            $visitor_qus = $request->visitor_qus;
            $company_qus = $request->company_qus;

            $visitor = [];
            if($visitor_qus){
                foreach ($visitor_qus as $vk => $vqus){
                    if($vqus){
                        $answer = [
                            'type' => $request->visitor_ans['type'][$vk],
                            'code' => $request->visitor_ans['code'][$vk],
                            'link' => $request->visitor_ans['link'][$vk],
                        ];
                        if ($request->hasFile("visitor_ans.file.$vk")) {
                            $file = uploadFile($request->visitor_ans['file'][$vk], SETTING_PATH, 'guides_visitor_');
                            $answer['file'] = $file;
                        }elseif (isset($request->visitor_ans['old_file'][$vk])){
                            $answer['file'] = $request->visitor_ans['old_file'][$vk];
                        }
                        $visitor[] = [
                            'question' => $vqus,
                            'answer' => $answer,
                        ];
                    }
                }
            }

            $guides = Setting::updateOrCreate(
                ['type' => 'visitor_guides'], // condition
                ['value' => json_encode($visitor)] // data to update/insert
            );

            $company = [];
            if($company_qus){
                foreach ($company_qus as $ck => $cqus){
                    if($cqus){
                        $answer2 = [
                            'type' => $request->company_ans['type'][$ck],
                            'code' => $request->company_ans['code'][$ck],
                            'link' => $request->company_ans['link'][$ck],
                        ];
                        if ($request->hasFile("company_ans.file.$ck")) {
                            $file = uploadFile($request->company_ans['file'][$ck], SETTING_PATH, 'guides_company_');
                            $answer2['file'] = $file;
                        }elseif (isset($request->company_ans['old_file'][$ck])){
                            $answer2['file'] = $request->company_ans['old_file'][$ck];
                        }
                        $company[] = [
                            'question' => $cqus,
                            'answer' => $answer2,
                        ];
                    }
                }
            }

            $guides = Setting::updateOrCreate(
                ['type' => 'company_guides'], // condition
                ['value' => json_encode($company)] // data to update/insert
            );

            if ($guides) {
                return $this->sendSuccess("Guides Details Updated Successfully!");
            } else {
                return $this->sendError("Unable to update the Guides.");
            }

        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function guidesFileDelete(Request $request)
    {
        try {
            $guides = Setting::where('type','=',$request->type)->first();
            $guides = $guides ? json_decode($guides->value, true):[];
            $file = $guides[$request->id]['answer']['file'];
            if ( isset($guides[$request->id]) && $guides[$request->id]['answer']['file']) {
                deleteImage($guides[$request->id]['answer']['file'], SETTING_PATH);
            }
            return $this->sendSuccess("file has been removed successfully!");
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function getGuidesFile(Request $request)
    {
        try {
            $guides = Setting::where('type','=',$request->type)->first();
            $guides = $guides ? json_decode($guides->value, true):[];
            $file = $guides[$request->id]['answer']['file'];
            $fileUrl = asset(SETTING_PATH.$guides[$request->id]['answer']['file']);
            return $this->sendSuccess(['file' => $file,'url' => $fileUrl]);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }
}
