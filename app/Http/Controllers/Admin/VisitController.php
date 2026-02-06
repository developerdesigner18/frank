<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ReportStatus;
use App\Mail\VisitApprovedMail;
use App\Enums\BranchStatus;
use App\Enums\QuestionnaireStatus;
use App\Enums\UserStatus;
use App\Enums\VisitStatus;
use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Branch;
use App\Models\Questionnaire;
use App\Models\User;
use App\Models\Visit;
use App\Models\VisitReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Mail\NewVisitMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Yajra\DataTables\Facades\DataTables;

class VisitController extends Controller
{
    use ResponseTrait;

    public function index(String $page)
    {
//        $branch_list = Branch::all();
        $branch_list = Branch::where('status',BranchStatus::ACTIVE->value)->get();
        $questionnaires_list = Questionnaire::where('status', QuestionnaireStatus::ACTIVE->value)
            ->where('is_published', 1)
            ->get();
        $visitors_list = User::where('status', 'ACTIVE')
            ->whereNotNull('email_verified_at')
            ->get();
        return view('admin.visit.index',compact('page','branch_list','questionnaires_list','visitors_list'));
    }

    public function list(Request $request, $page)
    {
        try {
            $query = Visit::query();
            if($page=='available'){
                // Show OPEN visits with NO interests
                $query->where('status','=','OPEN')
                    ->whereDoesntHave('interests');
            }elseif ($page=='interested'){
                // Show visits with ANY interests AND status is OPEN or INTERESTED
                $query->whereHas('interests')
                    ->where(function ($q) {
                        $q->where('status', VisitStatus::OPEN->value)
                            ->orWhere('status', VisitStatus::INTERESTED->value);
                    });
            }elseif ($page=='scheduled'){
                $query->where(function($query) {
                    $query->where('status', 'IN_PROGRESS')
                        ->orWhere('status', 'SCHEDULED')
                        ->orWhere('status', 'ASSIGNED');
                });
            }elseif ($page=='pending'){
                $query->where('status','=','PENDING');
            }elseif ($page=='completed'){
                $query->where('status','=','COMPLETED');
            }

            // Apply type filter if provided
            if($request->type && is_array($request->type) && !in_array('all', $request->type)) {
                $query->where(function($q) use ($request) {
                    foreach($request->type as $type) {
                        if($type == 'available') {
                            $q->orWhere(function ($query) {
                                $query->where('status', 'OPEN')
                             ->whereDoesntHave('interests');
                            });
                        } elseif($type == 'interested') {
                            $q->orWhere(function ($query) {
                                $query->where(function ($q) {
                                    $q->where('status', 'OPEN')
                                        ->orWhere('status', 'INTERESTED');
                                })->whereHas('interests');
                            });
                        } elseif($type == 'scheduled') {
                            $q->orWhere(function($q2) {
                                $q2->where('status','IN_PROGRESS')
                                    ->orWhere('status','SCHEDULED')
                                    ->orWhere('status','ASSIGNED');
                            });
                        } elseif($type == 'pending') {
                            $q->orWhere('status','PENDING');
                        } elseif($type == 'completed') {
                            $q->orWhere('status','COMPLETED');
                        }
                    }
                });
            }

            // ✅ Search filter
            if ($request->filled('search')) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->whereHas('branch', function ($sub) use ($search) {
                        $sub->where('branch_name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('visitor', function ($sub) use ($search) {
                        $sub->where('first_name', 'like', "%{$search}%") // fix column name
                        ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
                    })
                    ->orWhereHas('questionnaire', function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%");
                    });
                });
            }

            // ✅ Sorting
            if ($request->sort_by === 'branch_asc') {
                $query->orderBy(
                    Branch::select('branch_name')->whereColumn('branches.id', 'visits.branch_id'),
                    'asc'
                );
            } elseif ($request->sort_by === 'branch_desc') {
                $query->orderBy(
                    Branch::select('branch_name')->whereColumn('branches.id', 'visits.branch_id'),
                    'desc'
                );
            } elseif ($request->sort_by === 'id_asc') {
//                dd($request->sort_by);
                $query->orderBy('id', 'asc');
            } elseif ($request->sort_by === 'id_desc') {
//                dd($request->sort_by);
                $query->orderBy('id', 'desc');
            }

            $resultData = $query->get();
//            dd($resultData);
            $html = view('admin.visit.list', compact('resultData'))->render();
            return $this->sendSuccess($html);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function completedList(Request $request, $page)
    {

        try {
            $sort_by = $request->sort_by;
            $search = $request->search;

            $resultData = VisitReport::with('visit')
                ->whereHas('visit', function ($query) {
                    $query->where('status', VisitStatus::COMPLETED->value);
                })
                ->where('visit_reports.status', ReportStatus::COMPLETED->value)
                ->join('visits', 'visits.id', '=', 'visit_reports.visit_id')
                ->join('branches', 'branches.id', '=', 'visits.branch_id')
                ->select('visit_reports.*') // select only main table columns
                ->when(!empty($search), function ($q) use ($search) {
                    $q->where('branches.branch_name', 'like', "%{$search}%")
                    // Questionnaire name
                    ->orWhereExists(function ($exists) use ($search) {
                        $exists->selectRaw(1)
                            ->from('questionnaires')
                            ->whereColumn('questionnaires.id', 'visits.questionnaire_id')
                            ->where('questionnaires.name', 'like', "%{$search}%");
                    });
                })
                ->when($sort_by === 'branch_asc', function ($q) {
                    $q->orderBy('branches.branch_name', 'asc');
                })
                ->when($sort_by === 'branch_desc', function ($q) {
                    $q->orderBy('branches.branch_name', 'desc');
                })
                ->when($sort_by === 'date_asc', function ($q) {
                    $q->orderBy('visit_reports.started_date', 'asc');
                })
                ->when($sort_by === 'date_desc', function ($q) {
                    $q->orderBy('visit_reports.started_date', 'desc');
                })
                ->get();


            $html = view('admin.visit.list-completed', compact('resultData'))->render();
            return $this->sendSuccess($html);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'branch_id' => ['required', Rule::exists('branches', 'id')],
            'questionnaire_id' => ['required', Rule::exists('questionnaires', 'id')],
            'start_datetime' => ['required'],
            'end_datetime' => ['required'],
            'price' => ['required'],
            'expense_estimation_min' => ['required'],
            'expense_estimation_max' => ['required'],
            'description' => ['nullable'],
//            'visitor_id' => ['required', Rule::exists('users', 'id')],
            'status' => ['required', new Enum(VisitStatus::class)]
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        try {
            DB::beginTransaction();

            do {
                $unioqid = (string) Str::uuid();
            } while (Visit::where('unioqid', $unioqid)->exists());

            $visit = new Visit();
            $visit->unioqid = $unioqid;
            $visit->branch_id = $request->branch_id;
            $visit->questionnaire_id = $request->questionnaire_id;
            $visit->start_datetime = $request->start_datetime;
            $visit->end_datetime = $request->end_datetime;
            $visit->price = $request->price;
            $visit->expense_estimation_min = $request->expense_estimation_min;
            $visit->expense_estimation_max = $request->expense_estimation_max;
            $visit->description = $request->description;
            $visit->visitor_id = $request->visitor_id??null;
            $visit->status = $request->status;
            $visit->save();

            // ============================================================
            // 🆕 NEW: Send notification email when visit is created
            // ============================================================
            if ($request->has('send_mail') && $request->send_mail == '1' && $visit->status->value === VisitStatus::OPEN->value) {

                // Send to all active visitors (User model represents mystery visitors)
                $activeVisitors = User::where('status', UserStatus::ACTIVE->value)
                    ->whereNotNull('email')
                    ->get();

                foreach ($activeVisitors as $visitor) {
                    try {

                        if($visitor->receive_visit_emails) {
                            // Send the email (using send instead of queue for immediate delivery)
                            Mail::to($visitor->email)->send(new NewVisitMail($visit,$visitor->first_name));
                        }
                    } catch (\Exception $e) {
                        // Log error but don't fail the entire operation
                        \Log::error('Failed to send new visit email to ' . $visitor->email . ': ' . $e->getMessage());
                    }
                }

                // Option 2: Send to admin for notification
                // if (env('ADMIN_EMAIL')) {
                //     Mail::to(env('ADMIN_EMAIL'))->send(new NewVisitMail($visit));
                // }
            }
        // ============================================================

            DB::commit();
            return $this->sendSuccess('Visit added successfully!');
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError($exception->getMessage());
        }
    }

    public function edit(Request $request)
    {
        try {
            $response = Visit::where('id', $request->id)->first();
            if (!$response) {
                return $this->sendError("Visit not found");
            }

            return $this->sendResponse("Visit details", $response);
        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required'],
            'branch_id' => ['required', Rule::exists('branches', 'id')],
            'questionnaire_id' => ['required', Rule::exists('questionnaires', 'id')],
            'start_datetime' => ['required'],
            'end_datetime' => ['required'],
            'price' => ['required'],
            'expense_estimation_min' => ['required'],
            'expense_estimation_max' => ['required'],
            'description' => ['nullable'],
//            'visitor_id' => ['required', Rule::exists('users', 'id')],
            'status' => ['required', new Enum(VisitStatus::class)]
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        try {
            DB::beginTransaction();

            $visit = Visit::findOrFail($request->id);
            if(!$visit->unioqid){
                do {
                    $unioqid = (string) Str::uuid();
                } while (Visit::where('unioqid', $unioqid)->exists());

                $visit->unioqid = $unioqid;
            }
            $visit->branch_id = $request->branch_id;
            $visit->questionnaire_id = $request->questionnaire_id;
            $visit->start_datetime = $request->start_datetime;
            $visit->end_datetime = $request->end_datetime;
            $visit->price = $request->price;
            $visit->expense_estimation_min = $request->expense_estimation_min;
            $visit->expense_estimation_max = $request->expense_estimation_max;
            $visit->description = $request->description;
            $visit->visitor_id = $request->visitor_id??null;
            $visit->status = $request->status;
            $visit->save();

            DB::commit();
            return $this->sendSuccess('Visit updated successfully!');
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError($exception->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:visits,id',
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $visit = Visit::findOrFail($request->id);
            $visit->delete();

            return $this->sendSuccess("Visit has been removed successfully");
        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function duplicate(Request $request)
    {
        try {
            $visit = Visit::findOrFail($request->id);

            // Replicate (clone) the visit
            $newVisit = $visit->replicate();

            // Optionally change fields (like created_at, updated_at, or status)
            $newVisit->status = 'OPEN';
            $newVisit->published = 1;
            $newVisit->created_at = now();
            $newVisit->updated_at = now();

            // Save the new visit
            $newVisit->save();

            return $this->sendSuccess("Visit has been duplicated successfully");
        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:visits,id',
                'status' => ['required', Rule::in(array_column(VisitStatus::cases(), 'value'))]
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $visit = Visit::findOrFail($request->id);
            $visit->status = VisitStatus::from($request->status);
            $visit->save();

            return $this->sendSuccess("Visit status updated successfully");
        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function reject(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:visits,id',
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            DB::beginTransaction();

            $visit = Visit::findOrFail($request->id);

            // Delete ALL interest records for this visit (reject all visitors)
            \App\Models\VisitInterest::where('visit_id', $request->id)->delete();

            // Reset visit to OPEN status
            $visit->update(['status'=>'OPEN','visitor_id'=>null]);

            DB::commit();

            return $this->sendSuccess("Visit has been rejected successfully. All visitor interests have been removed.");
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function availableVisits()
    {
        return view('admin.visit.available');
    }

    public function availableList(Request $request)
    {
        try {
            // Show OPEN visits that have NO interest records from any visitor
            $response = Visit::with(['branch', 'questionnaire'])
                ->where('status','=','OPEN')
                ->whereDoesntHave('interests') // Exclude visits with any interests
                ->latest();

            return DataTables::eloquent($response)
                ->addIndexColumn()
                ->addColumn('branch', function ($row) {
                    return $row->branch->branch_name ?? '-';
                })
                ->addColumn('questionnaire', function ($row) {
                    return $row->questionnaire->name ?? '-';
                })
                ->addColumn('status', function ($row) {
                    $statusOptions = '';
                    foreach (VisitStatus::cases() as $status) {
                        $selected = $row->status->value === $status->value ? 'selected' : '';
                        $statusOptions .= '<option value="' . $status->value . '" ' . $selected . '>' . $status->value . '</option>';
                    }
                    return '<select class="form-select visit-status-select form-select-sm" data-id="' . $row->id . '">' . $statusOptions . '</select>';
                })
                ->addColumn('start_datetime', function ($row) {
                    return dateToHuman($row->start_datetime, 'd M Y H:i');
                })
                ->addColumn('end_datetime', function ($row) {
                    return dateToHuman($row->end_datetime, 'd M Y H:i');
                })
                ->addColumn('action', function ($row) {
                    return '<ul class="list-inline mb-0 d-flex justify-content-center text-center">
                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                <button type="button" onclick="getVisit(' . $row->id . ',this)" class="btn btn-outline-info btn-icon waves-effect waves-light material-shadow-none">
                                    <i class="ri-pencil-fill fs-16"></i>
                                </button>
                            </li>
                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                <button type="button" onclick="removeVisit(' . $row->id . ',this)" class="btn btn-outline-danger btn-icon waves-effect waves-light material-shadow-none">
                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                </button>
                            </li>
                        </ul>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);

        } catch (\Exception $exception) {
            return $this->sendDataTableError(ERROR_500, [], 500);
        }
    }

    public function interestedVisits()
    {
        return view('admin.visit.interested');
    }

    public function interestedList(Request $request)
    {
        try {
            // Show visits that have at least one interested visitor (from visit_interests table)
            // AND have NOT been assigned to anyone yet
            $response = Visit::with(['branch', 'questionnaire', 'interests.user'])
                ->whereHas('interests') // Only visits with interest records
                ->whereNull('visitor_id') // Exclude visits already assigned
                ->latest();

            return DataTables::eloquent($response)
                ->addIndexColumn()
                ->addColumn('visitorName', function ($row) {
                    // Get all interested visitors for this visit from VisitInterest table
                    $interestedVisitors = $row->interests()->with('user')->get();

                    if ($interestedVisitors->isEmpty()) {
                        return '-';
                    }

                    // Return comma-separated list of all interested visitor names
                    return $interestedVisitors->map(function($interest) {
                        return $interest->user->first_name . ' ' . $interest->user->last_name;
                    })->join(', ');
                })
                ->addColumn('branch', function ($row) {
                    return $row->branch->branch_name ?? '-';
                })
                ->addColumn('questionnaire', function ($row) {
                    return $row->questionnaire->name ?? '-';
                })
                ->addColumn('status', function ($row) {
                    $statusOptions = '';
                    foreach (VisitStatus::cases() as $status) {
                        $selected = $row->status->value === $status->value ? 'selected' : '';
                        $statusOptions .= '<option value="' . $status->value . '" ' . $selected . '>' . $status->value . '</option>';
                    }
                    return '<select class="form-select visit-status-select form-select-sm" data-id="' . $row->id . '">' . $statusOptions . '</select>';
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
                    return '<ul class="list-inline mb-0 d-flex justify-content-center text-center">
                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="">
                            <button type="button" onclick="assignedVisit(' . $row->id . ',this)" class="btn btn-outline-info btn-sm waves-effect waves-light material-shadow-none">
                                Assigned
                            </button>
                        </li>
                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="">
                            <button type="button" onclick="rejectVisit(' . $row->id . ',this)" class="btn btn-outline-danger btn-sm waves-effect waves-light material-shadow-none">
                                Reject
                            </button>
                        </li>
                    </ul>';
                })
                ->rawColumns(['visitorName', 'action', 'status'])
                ->make(true);

        } catch (\Exception $exception) {
            return $this->sendDataTableError(ERROR_500, [], 500);
        }
    }

    public function scheduledVisits()
    {
        return view('admin.visit.scheduled');
    }

    public function scheduledList(Request $request)
    {
        try {
            $response = Visit::with(['branch', 'questionnaire'])->where(function($query) {
                $query->where('status', 'IN_PROGRESS')
                    ->orWhere('status', 'SCHEDULED')
                    ->orWhere('status', 'ASSIGNED');
            })->latest();

            return DataTables::eloquent($response)
                ->addIndexColumn()
                ->addColumn('visitorName', function ($row) {
                    return $row->visitor->first_name.' '.$row->visitor->last_name;
                })
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
                    return '<ul class="list-inline mb-0 d-flex justify-content-center text-center">
                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="">
                                <button type="button" onclick="assignedVisit(' . $row->id . ',this)" class="btn btn-outline-info btn-sm waves-effect waves-light material-shadow-none">
                                    Asigned
                                </button>
                            </li>
                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="">
                                <button type="button" onclick="rejectVisit(' . $row->id . ',this)" class="btn btn-outline-danger btn-sm waves-effect waves-light material-shadow-none">
                                    Reject
                                </button>
                            </li>
                        </ul>';
                })
                ->rawColumns(['visitorName', 'action', 'status'])
                ->make(true);

        } catch (\Exception $exception) {
            return $this->sendDataTableError(ERROR_500, [], 500);
        }
    }

    public function pendingVisits()
    {

        return view('admin.visit.pending');
    }

    public function pendingList(Request $request)
    {

        try {
            $response = Visit::with(['branch', 'questionnaire'])->where('status','=','PENDING')->latest();

            return DataTables::eloquent($response)
                ->addIndexColumn()
                ->addColumn('visitorName', function ($row) {
                    return $row->visitor->first_name.' '.$row->visitor->last_name;
                })
                ->addColumn('branch', function ($row) {
                    return $row->branch->branch_name ?? '-';
                })
                ->addColumn('questionnaire', function ($row) {
                    return $row->questionnaire->name ?? '-';
                })
                ->addColumn('status', function ($row) {
                    $statusOptions = '';
                    foreach (VisitStatus::cases() as $status) {
                        $selected = $row->status->value === $status->value ? 'selected' : '';
                        $statusOptions .= '<option value="' . $status->value . '" ' . $selected . '>' . $status->value . '</option>';
                    }
                    return '<select class="form-select visit-status-select form-select-sm" data-id="' . $row->id . '">' . $statusOptions . '</select>';
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
                    return '<ul class="list-inline mb-0 d-flex justify-content-center text-center">
                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="">
                                <button type="button" onclick="approvedVisit(' . $row->id . ',this)" class="btn btn-outline-info btn-sm waves-effect waves-light material-shadow-none">
                                    Approved
                                </button>
                            </li>
                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="">
                                <a href="'.route('admin.visit.generate.pdf',$row['id']).'" class="btn btn-outline-success btn-sm material-shadow-none" target="_blank">
                                    PDF
                                </a>
                            </li>
                        </ul>';
                })
                ->rawColumns(['visitorName', 'action', 'status'])
                ->make(true);

        } catch (\Exception $exception) {
            return $this->sendDataTableError(ERROR_500, [], 500);
        }
    }

    public function generatePDFDownload(String $visit_id)
    {
        // Increase memory limit and execution time for PDF generation
        ini_set('memory_limit', '512M');  // Increase from 128MB to 512MB
        set_time_limit(300);              // Increase to 5 minutes

        $visitData = VisitReport::where(['visit_id' => $visit_id])->first();

        // Check if visit report exists
        if (!$visitData) {
            abort(404, 'Visit report not found. Please ensure the visit has been completed and submitted.');
        }

        if(gettype($visitData->response_data)=='array'){
            $response_data = $visitData->response_data;
        }else{
            $response_data = (array) json_decode($visitData->response_data);
        }

        // Calculate chart data
        $qVisitIds = $visitData->visit->questionnaire
            ->visits()
            ->whereIn('status', ['PENDING', 'COMPLETED'])
            ->pluck('id')
            ->toArray();

        $currentYear = Carbon::now()->year;
        $visitReports = VisitReport::whereIn('visit_id', $qVisitIds)->whereYear('created_at', $currentYear)->get();

        $minDate = $visitReports->min('created_at');
        $maxDate = $visitReports->max('created_at');

        $period = Carbon::parse($minDate)->startOfMonth()->monthsUntil(Carbon::parse($maxDate)->endOfMonth());

        $rangeMonths = [];
        foreach ($period as $date) {
            $rangeMonths[] = $date->format('M');
        }

        $groupedVisitReports = $visitReports->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('M');
        });

        $newArr = [];
        if($minDate->month != $maxDate->month){
            foreach ($response_data['category'] as $catKey => $catName) {
                $result = [];

                foreach ($rangeMonths as $month) {
                    $scores = 0;
                    $max_scores = 0;

                    if (isset($groupedVisitReports[$month])) {
                        foreach ($groupedVisitReports[$month] as $report) {
                            $json = is_array($report->response_data)
                                ? $report->response_data
                                : json_decode($report->response_data, true);

                            if (isset($json['category'][$catKey])) {
                                $scores += $json['score_result'][$catKey] ?? 0;
                                $max_scores += $json['max_score_result'][$catKey] ?? 0;
                            }
                        }
                    }
                    $final_score = ($scores>0)? round(($scores / $max_scores)*100,2) :0;

                    $result[$month] = $final_score;
                }

                // final structure
                $months = array_keys($result);   // full month list
                $scores = $result;              // month => score

                $newArr[$catName] = ['month'=>$months, 'score'=>$scores];
            }
        }

        // Logic to determine Logo and Footer details based on Subdealer
        $subdealer = $visitData->visit->branch->company->subdealer ?? null;
        $main_logo = public_path('assets/logo/bar_logo.png');

        if ($subdealer && $subdealer->getRawOriginal('logo')) {
            $logoPath = public_path(SUBDEALER_LOGO_PATH . $subdealer->getRawOriginal('logo'));
            if (file_exists($logoPath)) {
                $main_logo = $logoPath;
            }
        }

        $data = [
            'title' => $response_data['title']??'Mystery Visit Thuishaven',
            'main_logo' => $main_logo,
            'bar_logo' => public_path('assets/logo/bar_logo.png'),
            'visitData' => $visitData,
            'response_data' => $response_data,
            'chart_data' => $newArr,
        ];

        //        return view('user.visit.reportPDF',$data);
        $pdf = PDF::loadView('admin.visit.reportPDF', $data);

        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $canvas = $dompdf->getCanvas();

        // Prepare footer variables
        $footer_company = "MysteryVisits B.V.";
        $footer_phone = "tel: 024 234 28 13";
        $footer_email = "office@checkmijnzaak.nl";

        if ($subdealer) {
            if ($subdealer->name) $footer_company = $subdealer->name;
            if ($subdealer->phone) $footer_phone = "tel: " . $subdealer->phone;
            if ($subdealer->email) $footer_email = $subdealer->email;
        }

        $branch_name = $visitData->visit->branch->branch_name??'';
        $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) use ($branch_name, $footer_company, $footer_phone, $footer_email) {
            $font = $fontMetrics->get_font("helvetica", "normal");
            $size = 9;

            // Left side: Company Name
            $canvas->text(25, 815, $footer_company, $font, $size);

            // Middle Left: Phone number
            $canvas->text(160, 815, $footer_phone, $font, $size);

            // Middle Right: Email
            $canvas->text(278, 815, $footer_email, $font, $size);

            // Right side: Restaurant name
            $canvas->text(425, 815, "$branch_name", $font, $size);

            // Page number at the very right
            $canvas->text(555, 815, "$pageNumber", $font, $size);
        });

        $filePath = public_path(VISIT_PDF_PATH).'visit-'.$visit_id.'.pdf';
        $pdf->save($filePath);

        return $filePath;
    }

    /**
     * View/Stream the PDF report
     */
    public function generatePDF(String $visit_id)
    {
        $visitData = VisitReport::where(['visit_id' => $visit_id])->first();

        if (!$visitData) {
            abort(404, 'Visit report not found.');
        }

        $branchName = $visitData->visit->branch->branch_name ?? 'Branch';
        $date = date('d-m-Y');
        $displayName = "Mystery Visit " . $branchName . " " . $date . ".pdf";

        // 1. Check if PDF exists in database and on disk
        if ($visitData->report_pdf_url && file_exists(public_path($visitData->report_pdf_url))) {
            return response()->file(public_path($visitData->report_pdf_url), [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $displayName . '"'
            ]);
        }

        // 2. Fallback: Generate, Save to DB, then View
        $pdfPath = $this->actuallyGenerateAndSavePDF($visit_id);
        
        return response()->file($pdfPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $displayName . '"'
        ]);
    }

    /**
     * Download the PDF report
     */
    public function downloadPDF(String $visit_id)
    {
        $visitData = VisitReport::where(['visit_id' => $visit_id])->first();

        if (!$visitData) {
            abort(404, 'Visit report not found.');
        }

        $branchName = $visitData->visit->branch->branch_name ?? 'Branch';
        $date = date('d-m-Y');
        $displayName = "Mystery Visit " . $branchName . " " . $date . ".pdf";

        // 1. Check if PDF exists in database and on disk
        if ($visitData->report_pdf_url && file_exists(public_path($visitData->report_pdf_url))) {
            return response()->download(public_path($visitData->report_pdf_url), $displayName);
        }

        // 2. Fallback: Generate, Save to DB, then Download
        $pdfPath = $this->actuallyGenerateAndSavePDF($visit_id);
        
        return response()->download($pdfPath, $displayName);
    }

    /**
     * Internal helper to generate and save PDF to disk/database
     */
    private function actuallyGenerateAndSavePDF($visit_id)
    {
        $visitData = VisitReport::where(['visit_id' => $visit_id])->first();
        
        ini_set('memory_limit', '1024M');
        set_time_limit(300);

        if(gettype($visitData->response_data)=='array'){
            $response_data = $visitData->response_data;
        }else{
            $response_data = (array) json_decode($visitData->response_data);
        }
        
        $qVisitIds = $visitData->visit->questionnaire->visits()->whereIn('status', ['PENDING', 'COMPLETED', 'APPROVED'])->pluck('id')->toArray();
        $currentYear = Carbon::now()->year;
        $visitReports = VisitReport::whereIn('visit_id', $qVisitIds)->whereYear('created_at', $currentYear)->get();
        $minDate = $visitReports->min('created_at');
        $maxDate = $visitReports->max('created_at');

        $groupedVisitReports = $visitReports->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('M');
        });

        $newArr = [];
        
        $period = Carbon::parse($minDate)->startOfMonth()->monthsUntil(Carbon::parse($maxDate)->endOfMonth());
        $rangeMonths = [];
        foreach ($period as $date) { $rangeMonths[] = $date->format('M'); }

        if($minDate->month != $maxDate->month){
            foreach ($response_data['category'] as $catKey => $catName) {
                $result = [];
                foreach ($rangeMonths as $month) {
                    $scores = 0; $max_scores = 0;
                    if (isset($groupedVisitReports[$month])) {
                        foreach ($groupedVisitReports[$month] as $report) {
                            $json = is_array($report->response_data) ? $report->response_data : json_decode($report->response_data, true);
                            if (isset($json['category'][$catKey])) {
                                $scores += $json['score_result'][$catKey] ?? 0;
                                $max_scores += $json['max_score_result'][$catKey] ?? 0;
                            }
                        }
                    }
                    $result[$month] = ($scores>0)? round(($scores / $max_scores)*100,2) :0;
                }
                $newArr[$catName] = ['month'=>array_keys($result), 'score'=>$result];
            }
        }

        $subdealer = $visitData->visit->branch->company->subdealer ?? null;
        $main_logo = public_path('assets/logo/bar_logo.png');
        if ($subdealer && $subdealer->getRawOriginal('logo')) {
            $logoPath = public_path(SUBDEALER_LOGO_PATH . $subdealer->getRawOriginal('logo'));
            if (file_exists($logoPath)) $main_logo = $logoPath;
        }

        $data = [
            'title' => $response_data['title']??'Mystery Visit Report',
            'main_logo' => $main_logo,
            'bar_logo' => public_path('assets/logo/Bitmap.png'),
            'visitData' => $visitData,
            'response_data' => $response_data,
            'chart_data' => $newArr,
        ];

        $pdf = PDF::loadView('admin.visit.reportPDF', $data);
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $canvas = $dompdf->getCanvas();

        $footer_company = "MysteryVisits.nl"; $footer_phone = "tel: 024 234 28 13"; $footer_email = "welkom@mysteryvisits.nl";

        if ($subdealer) {
            if ($subdealer->name) $footer_company = $subdealer->name;
            if ($subdealer->phone) $footer_phone = "tel: " . $subdealer->phone;
            if ($subdealer->email) $footer_email = $subdealer->email;
        }

        $branch_name = $visitData->visit->branch->branch_name??'';
        $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) use ($branch_name, $footer_company, $footer_phone, $footer_email) {
            $font = $fontMetrics->get_font("helvetica", "normal");
            $size = 9;
            $canvas->text(25, 815, $footer_company, $font, $size);
            $canvas->text(160, 815, $footer_phone, $font, $size);
            $canvas->text(278, 815, $footer_email, $font, $size);
            $canvas->text(425, 815, "$branch_name", $font, $size);
            $canvas->text(555, 815, "$pageNumber", $font, $size);
        });

        $branch_name = $visitData->visit->branch->branch_name ?? 'Branch';
        $date = date('d-m-Y');
        $fileName = 'Mystery Visit ' . $branch_name . ' ' . $date . ' ' . time() . '.pdf';
        $filePath = public_path(VISIT_PDF_PATH) . $fileName;
        
        // Delete old file if exists
        if ($visitData->report_pdf_url && file_exists(public_path($visitData->report_pdf_url))) {
            @unlink(public_path($visitData->report_pdf_url));
        }

        if (!file_exists(public_path(VISIT_PDF_PATH))) {
            mkdir(public_path(VISIT_PDF_PATH), 0755, true);
        }

        $pdf->save($filePath);

        // Update DB
        $visitData->update(['report_pdf_url' => VISIT_PDF_PATH . $fileName]);

        return $filePath;
    }

    public function publishedStatus(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:visits,id',
            ]);
            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $visit = Visit::find($request->id);
            $visit->update(['published'=>$request->status]);

            return $this->sendSuccess('Visit published successfully');
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function visitReportStatus(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:visits,id',
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $visit_report = VisitReport::where(['visit_id' => $request->id])->first();
            $visit = Visit::findOrFail($request->id);

            if($request->type=='reject'){
                $visit->update(['status'=>VisitStatus::IN_PROGRESS->value]);
                return $this->sendSuccess("Visit has been rejected and moved back to in-progress");
            }else{
                $visit_report->update(['status'=>ReportStatus::COMPLETED->value]);
                $visit->update(['status'=>VisitStatus::COMPLETED->value]);

                // Dispatch PDF generation to background queue
                \App\Jobs\GenerateVisitPdfJob::dispatch($request->id);

                return $this->sendSuccess("Visit has been approved successfully. PDF is being generated in the background.");
            }
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function visitReportReview($report_uid)
    {
        $visit_report_data =  VisitReport::where(['report_uid' => $report_uid])->first();
        if(!$visit_report_data){
            return redirect()->route('admin.visit.index',['page'=>'pending']);
        }
        $visit = $visit_report_data->visit;
        $visit_id = $visit->id;

        $old_questions = $old_response_data = [];
        if(isset($visit_report_data)){
            if(gettype($visit_report_data->response_data)=='array'){
                $old_response_data = $visit_report_data->response_data;
                $old_questions = $old_response_data['question'];
            }else{
                $old_response_data = json_decode($visit_report_data->response_data, true);
                $old_questions = $old_response_data['question'];
            }
        }

        $questionnaire = $visit->questionnaire;
        $payload = json_decode($questionnaire->payload,true);

        return view('admin.visit.review',compact('visit','questionnaire', 'payload', 'visit_report_data', 'old_questions', 'visit_id'));
    }

    public function assignVisitor(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'visit_id' => 'required|exists:visits,id',
                'visitor_id' => 'required|exists:users,id',
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            DB::beginTransaction();
            $visit = Visit::findOrFail($request->visit_id);

            $interest = \App\Models\VisitInterest::where('visit_id', $request->visit_id)
                ->where('user_id', $request->visitor_id)
                ->first();

            if (!$interest) {
                DB::rollBack();
                return $this->sendError('This visitor has not expressed interest in this visit');
            }

            $visit->visitor_id = $request->visitor_id;
            $visit->status = VisitStatus::ASSIGNED;
            $visit->save();

            \App\Models\VisitInterest::where('visit_id', $request->visit_id)
                ->where('user_id', '!=', $request->visitor_id)
                ->delete();

            $visit = Visit::with(['visitor', 'branch.company', 'questionnaire'])->find($request->visit_id);
            $pdfPath = null;

            if ($visit->visitor && $visit->visitor->email) {
                try {
                    Mail::to($visit->visitor->email)->send(new \App\Mail\VisitApprovedMail($visit, 'visitor', $pdfPath));
                } catch (\Exception $e) {
                    \Log::error('Failed to send visit approved email to visitor: ' . $e->getMessage());
                }
            }

            if (env('RECEIVER_MAIL')) {
                try {
                    Mail::to(env('RECEIVER_MAIL'))->send(new \App\Mail\VisitApprovedMail($visit, 'admin', $pdfPath));
                } catch (\Exception $e) {
                    \Log::error('Failed to send visit approved email to admin: ' . $e->getMessage());
                }
            }

            DB::commit();
            return $this->sendSuccess('Visitor assigned successfully and other interested visitors have been removed');
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function togglePricePayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'visit_id' => 'required|exists:visits,id',
            ]);
            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }
            $visitReport = VisitReport::where('visit_id', $request->visit_id)->first();
            if (!$visitReport) {
                return $this->sendError('Visit report not found', 404);
            }
            $visitReport->price_paid = !$visitReport->price_paid;
            $visitReport->save();
            $status = $visitReport->price_paid ? 'paid' : 'unpaid';
            return $this->sendSuccessWithData("Price marked as {$status} successfully", [
                'price_paid' => $visitReport->price_paid
            ]);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function toggleReimbursementPayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'visit_id' => 'required|exists:visits,id',
            ]);
            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }
            $visitReport = VisitReport::where('visit_id', $request->visit_id)->first();
            if (!$visitReport) {
                return $this->sendError('Visit report not found', 404);
            }
            $visitReport->reimbursement_paid = !$visitReport->reimbursement_paid;
            $visitReport->save();
            $status = $visitReport->reimbursement_paid ? 'paid' : 'unpaid';
            return $this->sendSuccessWithData("Reimbursement marked as {$status} successfully", [
                'reimbursement_paid' => $visitReport->reimbursement_paid
            ]);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }
}
