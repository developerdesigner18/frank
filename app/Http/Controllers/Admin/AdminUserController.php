<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        return view('admin.admin-user.index');
    }

    public function list(Request $request)
    {
        try {
            $query = Admin::query();

            // Search
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%");
                });
            }

            // Sort
            if ($request->has('sort_by') && $request->sort_by != '') {
                if ($request->sort_by == 'id_desc') {
                    $query->orderBy('id', 'desc');
                }
                elseif ($request->sort_by == 'id_asc'){
                    $query->orderBy('id', 'asc');
                }
                elseif ($request->sort_by == 'name_asc') {
                    $query->orderBy('name', 'asc');
                } elseif ($request->sort_by == 'name_desc') {
                    $query->orderBy('name', 'desc');
                }
            } else {
                $query->latest();
            }

            $admins = $query->get();

            $html = view('admin.admin-user.list', compact('admins'))->render();
            return $this->sendSuccess($html);

        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6|confirmed',
            'profile_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        try {
            DB::beginTransaction();

            $admin = new Admin();
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->password = Hash::make($request->password);

            if ($request->hasFile('profile_img')) {
                $file = uploadFile($request->profile_img, ADMIN_PROFILE_IMAGE_PATH, 'admin_');
                $admin->profile_img = $file;
            }

            $admin->save();

            DB::commit();
            return $this->sendSuccess(trans_message('admin_added_successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError($exception->getMessage());
        }
    }

    public function edit(Request $request)
    {
        try {
            $admin = Admin::findOrFail($request->id);
            return $this->sendResponse("Admin details", $admin);
        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:admins,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $request->id,
            'password' => 'nullable|min:6|confirmed',
            'profile_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        try {
            DB::beginTransaction();

            $admin = Admin::findOrFail($request->id);

            $admin->name = $request->name;
            $admin->email = $request->email;

            if ($request->filled('password')) {
                $admin->password = Hash::make($request->password);
            }

            if ($request->hasFile('profile_img')) {
                // Delete old image if exists
                if ($admin->profile_img) {
                    @unlink(public_path(ADMIN_PROFILE_IMAGE_PATH . basename($admin->profile_img)));
                }
                $file = uploadFile($request->profile_img, ADMIN_PROFILE_IMAGE_PATH, 'admin_');
                $admin->profile_img = $file;
            }

            $admin->save();

            DB::commit();
            return $this->sendSuccess(trans_message('admin_updated_successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError($exception->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:admins,id',
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $admin = Admin::findOrFail($request->id);

            // Prevent deleting yourself
            if ($admin->id === auth()->guard('admin')->id()) {
                return $this->sendError(trans_message('cannot_delete_yourself'));
            }

            // Delete profile image if exists
            if ($admin->profile_img) {
                @unlink(public_path(ADMIN_PROFILE_IMAGE_PATH . basename($admin->profile_img)));
            }

            $admin->delete();

            return $this->sendSuccess(trans_message('admin_deleted_successfully'));
        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }
}
