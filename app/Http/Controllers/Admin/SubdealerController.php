<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Subdealer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubdealerController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        return view('admin.subdealer.index');
    }

    public function list(Request $request)
    {
        try {
            $query = Subdealer::query();

            // Search
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%")
                      ->orWhere('phone', 'LIKE', "%{$search}%");
                });
            }

            // Sort
//            dd($request->sort_by)
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

            $subdealers = $query->get();

            $html = view('admin.subdealer.list', compact('subdealers'))->render();
            return $this->sendSuccess($html);

        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:subdealers,email',
            'phone' => 'required|string|max:20',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        try {
            DB::beginTransaction();

            $subdealer = new Subdealer();
            $subdealer->name = $request->name;
            $subdealer->email = $request->email;
            $subdealer->phone = $request->phone;

            if ($request->hasFile('logo')) {
                $file = uploadFile($request->logo, SUBDEALER_LOGO_PATH, 'subdealer_');
                $subdealer->logo = $file;
            }

            $subdealer->save();

            DB::commit();
            return $this->sendSuccess('Subdealer added successfully!');
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError($exception->getMessage());
        }
    }

    public function edit(Request $request)
    {
        try {
            $subdealer = Subdealer::findOrFail($request->id);
            return $this->sendResponse("Subdealer details", $subdealer);
        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:subdealers,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:subdealers,email,' . $request->id,
            'phone' => 'required|string|max:20',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        try {
            DB::beginTransaction();

            $subdealer = Subdealer::findOrFail($request->id);

            $subdealer->name = $request->name;
            $subdealer->email = $request->email;
            $subdealer->phone = $request->phone;

            if ($request->hasFile('logo')) {
                // Delete old logo if exists
                if ($subdealer->logo) {
                    @unlink(public_path(SUBDEALER_LOGO_PATH . basename($subdealer->logo)));
                }
                $file = uploadFile($request->logo, SUBDEALER_LOGO_PATH, 'subdealer_');
                $subdealer->logo = $file;
            }

            $subdealer->save();

            DB::commit();
            return $this->sendSuccess('Subdealer updated successfully!');
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError($exception->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:subdealers,id',
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $subdealer = Subdealer::findOrFail($request->id);

            // Delete logo if exists
            if ($subdealer->logo) {
                @unlink(public_path(SUBDEALER_LOGO_PATH . basename($subdealer->logo)));
            }

            $subdealer->delete();

            return $this->sendSuccess("Subdealer has been removed successfully");
        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }
}
