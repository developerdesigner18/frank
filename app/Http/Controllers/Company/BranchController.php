<?php

namespace App\Http\Controllers\Company;

use App\Enums\BranchStatus;
use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Company;
use App\Models\Visit;
use App\Models\VisitReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BranchController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        return view('company.branch.index');
    }

    public function listBranch(Request $request)
    {
        try {
            $response = Auth::guard('company')->user()->branches();

            return DataTables::eloquent($response)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return '<img src="' . $row->image . '" class="rounded avatar-sm" alt="Branch Logo">';
                })
                ->addColumn('created_at', function ($row) {
                    return dateToHuman($row->created_at, 'd M Y');
                })
                ->addColumn('company_name', function ($row) {
                    return $row->company->company_name;
                })
                ->addColumn('action', function ($row) {
                    return '<ul class="list-inline mb-0 d-flex justify-content-center text-center">
                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Visits">
                                <a href="'.route('company.branches.visits',$row['id']).'" class="btn btn-outline-primary btn-sm material-shadow-none">
                                    All Visits
                                </a>
                            </li>
                        </ul>';
                })
                ->rawColumns(['action', 'image'])
                ->make(true);

        } catch (\Exception $exception) {
            return $this->sendDataTableError(ERROR_500, [], 500);
        }
    }

    public function branchVisits(String $id)
    {
        $branch_id = $id;
        return view('company.branch.visits',compact('branch_id'));
    }

    public function branchVisitsList(String $id)
    {
        try {
            $response = Visit::with(['branch', 'questionnaire'])->where(['branch_id'=>$id])->latest();

            return DataTables::eloquent($response)
                ->addIndexColumn()
                ->addColumn('branch', function ($row) {
                    return $row->branch->branch_name ?? '-';
                })
                ->addColumn('questionnaire', function ($row) {
                    return $row->questionnaire->name ?? '-';
                })
                ->addColumn('start_datetime', function ($row) {
                    return dateToHuman($row->start_datetime, 'd M Y H:i');
                })
                ->addColumn('end_datetime', function ($row) {
                    return dateToHuman($row->end_datetime, 'd M Y H:i');
                })
                ->addColumn('expense_estimate', function ($row) {
                    return currency_icon().$row->expense_estimation_min.' - '.currency_icon().$row->expense_estimation_max;
                })
                ->addColumn('action', function ($row) {
                    $action = '<ul class="list-inline mb-0 d-flex justify-content-center text-center">
                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">';
                    if($row->status->name == 'COMPLETED' || $row->status->name == 'APPROVED'){
                        $action .= '<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="">
                                <a href="'.route('company.branches.visit.generate.pdf',$row['id']).'" class="btn btn-outline-success btn-sm material-shadow-none" target="_blank">
                                    PDF
                                </a>
                            </li>';
                    }
                    $action .= '</li>
                    </ul>';
                    return $action;
                })
                ->rawColumns(['action','expense_estimate'])
                ->make(true);

        } catch (\Exception $exception) {
            return $this->sendDataTableError(ERROR_500, [], 500);
        }
    }

    public function generatePDF(String $visit_id)
{
    $visitData = VisitReport::where(['visit_id' => $visit_id])->first();

    // Check if visit report exists
    if (!$visitData) {
        abort(404, 'Visit report not found. Please ensure the visit has been completed and submitted.');
    }

    // ✅ Check if PDF already exists in storage (reuse stored PDF)
    if ($visitData->report_pdf_url && file_exists(public_path($visitData->report_pdf_url))) {
        // Serve the pre-generated PDF directly - NO REGENERATION!
        return response()->file(public_path($visitData->report_pdf_url), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="visit-'.$visit_id.'.pdf"'
        ]);
    }

    // If PDF doesn't exist yet, generate it on-the-fly (fallback)
    ini_set('memory_limit', '512M');
    set_time_limit(300);

    if(gettype($visitData->response_data)=='array'){
        $response_data = $visitData->response_data;
    }else{
        $response_data = (array) json_decode($visitData->response_data);
    }

    $data = [
        'title' => $response_data['title']??'Mystery Visit Thuishaven',
        'main_logo' => public_path('assets/logo/bar_logo.png'),
        'bar_logo' => public_path('assets/logo/bar_logo.png'),
        'visitData' => $visitData,
        'response_data' => $response_data,
    ];

    $pdf = PDF::loadView('admin.visit.reportPDF', $data);
    $pdf->output();
    $dompdf = $pdf->getDomPDF();
    $canvas = $dompdf->getCanvas();

    $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
        $font = $fontMetrics->get_font("helvetica", "normal");
        $size = 9;

        $canvas->text(25, 815, "CheckMijnZaak.nl B.V.", $font, $size);
        $canvas->text(160, 815, "tel: 024 234 28 13", $font, $size);
        $canvas->text(278, 815, "office@checkmijnzaak.nl", $font, $size);
        $canvas->text(425, 815, "Chez l'Hêtre Restaurant", $font, $size);
        $canvas->text(555, 815, "$pageNumber", $font, $size);
    });

    return $pdf->stream('visit-'.$visit_id.'.pdf');
}
}
