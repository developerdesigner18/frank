<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Company;
use App\Http\Traits\ResponseTrait;

class CompanyController extends Controller
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
        return view('user.company.index');
    }

    public function companyList(Request $request)
    {
        try {
            $query = Company::query();

            //  Sorting
//            dd($request->sort_by);
            if (!empty($request->sort_by)) {
                switch ($request->sort_by) {
                    case 'id_asc':
                        $query->orderBy('id', 'asc');
                        break;
                    case 'id_desc':
                        $query->orderBy('id', 'desc');
                        break;
                    case 'name_asc':
                        $query->orderBy('company_name', 'asc');
                        break;
                    case 'name_desc':
                        $query->orderBy('company_name', 'desc');
                        break;
                }
            }

            $resultData = $query->get();
            $html = view('user.company.company_list', compact('resultData'))->render();
            return $this->sendSuccess($html);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }


}
