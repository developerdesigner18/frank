<?php

namespace App\Http\Controllers\User;

use App\Enums\ReportStatus;
use App\Enums\VisitStatus;
use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Branch;
use App\Models\Questionnaire;
use App\Models\Visit;
use App\Models\VisitInterest;
use App\Models\VisitReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class VisitController extends Controller
{
    use ResponseTrait;

    // 🔧 Constructor Function
    public function __construct()
    {
        $this->userData = Auth::guard('web')->user();
        $this->user_id = Auth::guard('web')->user()->id;
    }

    public function index(String $page)
    {

        return view('user.visit.index',compact('page'));
    }

    public function list(Request $request, $page)
    {

        try {
            $query = Visit::query();

            // Only filter by visitor_id for scheduled, pending, completed (not for available or interested)
            if(in_array($page, ['scheduled', 'pending', 'completed'])) {
                $query->where('visitor_id', '=', $this->user_id);
            }

            if($page=='available'){
                // Show OPEN visits that this user has NOT marked as interested
                // AND that have NOT been assigned to any visitor yet
                $query->where('status','=','OPEN')
                    ->whereNull('visitor_id') // Exclude visits already assigned to someone
                    ->whereDoesntHave('interests', function($subQuery) {
                        $subQuery->where('user_id', $this->user_id);
                    });
            }elseif ($page=='interested'){
                // Show visits where this user has expressed interest AND status is OPEN or INTERESTED
                // Once assigned/scheduled, it moves to 'Scheduled' tab
                // Also exclude visits that have been assigned to OTHER visitors
                $query->whereHas('interests', function($subQuery) {
                    $subQuery->where('user_id', $this->user_id);
                })->where(function ($q) {
                    $q->where('status', VisitStatus::OPEN->value)
                        ->orWhere('status', VisitStatus::INTERESTED->value);
                })->where(function ($q) {
                    // Only show if visit is unassigned OR assigned to this user
                    $q->whereNull('visitor_id')
                        ->orWhere('visitor_id', $this->user_id);
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
                            $q->orWhere('status','OPEN');
                        } elseif($type == 'interested') {
                            $q->orWhere('status','INTERESTED');
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
                $query->orderBy('id', 'asc');
            } elseif ($request->sort_by === 'id_desc') {
                $query->orderBy('id', 'desc');
            }

            // Eager load interests relationship to check if user has marked interest
            $query->with(['interests' => function($q) {
                $q->where('user_id', $this->user_id);
            }]);

            // Use distinct to prevent duplicate visits
            $resultData = $query->distinct()->get();
            $html = view('user.visit.list', compact('resultData', 'page'))->render();
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
                ->where('user_id', '=', $this->user_id)
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


            $html = view('user.visit.list-completed', compact('resultData'))->render();
            return $this->sendSuccess($html);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    public function survey(String $visit_id)
    {
        $visit = Visit::with(['branch', 'questionnaire'])->where('visitor_id','=',Auth::guard('web')->user()->id)->where('unioqid','=',$visit_id)->first();



        $visit_id = $visit->id;
        if(!$visit){

            return redirect()->route('visit.index');
        }
        $visit_report_data =  VisitReport::where(['visit_id' => $visit_id,'user_id' => Auth::guard('web')->user()->id])->first();

        $old_questions = [];
        if(isset($visit_report_data)){

            if(gettype($visit_report_data->response_data)=='array'){
                $old_response_data = $visit_report_data->response_data;
                $old_questions = $old_response_data['question'];
            }else{
                $old_response_data = json_decode($visit_report_data->response_data);
                $old_questions = (array) $old_response_data->question;
            }
        }

        $questionnaire = $visit->questionnaire;
        if(!$questionnaire){
            return redirect()->back()->with('error','Questionnaire not found or deleted.');
        }
        $payload = json_decode($questionnaire->payload,true);

        if(!$payload || !isset($payload['categories'])){
            return redirect()->back()->with('error','Questionnaire data is invalid or corrupted.');
        }

        Visit::find($visit_id)->update(['status'=>'IN_PROGRESS']);

        return view('user.visit.survey',compact('visit','questionnaire', 'payload', 'visit_report_data', 'old_questions'));
    }

    public function questionnaireUpdate(Request $request, $id)
    {

        try {
            DB::beginTransaction();

            $check =  VisitReport::where(['visit_id' => $request->visit_id])->first();

            $old_question = [];
            if(isset($check)){
                if(gettype($check->response_data)=='array'){
                    $old_response_data = $check->response_data;
                    $old_question = $old_response_data['question'];
                }else{
                    $old_response_data = json_decode($check->response_data);
                    $old_question = (array) $old_response_data->question;
                }
            }

            $category = $request->category;
            $question = [];
            $score = $maxScore = 0;
            $scoreArr = $cateScoreArr = [];
            if($request->question){
                foreach ($request->question as $qId => $qVal){
                    $na = $qVal['na']??'0';
                    $report_response_data = [];
                    $old_photos = [];
                    if(isset($old_question[$qVal['categoryId']])){
                        $report_response_data = $old_question[$qVal['categoryId']];
                        $report_result = array_values(array_filter($report_response_data, function ($item) use ($qId) {
                            if (gettype($item)=='array'){
                                return $item['qId'] == $qId;
                            }else{
                                return $item->qId == $qId;
                            }
                        }));
                        $report_result = (isset($report_result[0]))?(array)$report_result[0]:[];
                        $old_photos = (!empty($report_result) && isset($report_result['photo']))?$report_result['photo']:[];
                    }

                    $answer_image = $qVal['answer_old_image']??'';
                    if(isset($qVal['answer_image'])){
                        $file = surveyUploadFile2($qVal['answer_image'], SURVEY_QUESTIONNAIRE_IMAGES_PATH,'answer_');
                        $answer_image = asset(SURVEY_QUESTIONNAIRE_IMAGES_PATH.$file);
                    }

                    $answer = $qVal['answer']??'';
                    $answer_score = '';
                    if ($qVal['type'] == 'SELECT' || $qVal['type'] == 'RADIO'){
                        $exanswer = explode(',',$answer);
                        $answer = $exanswer[0];
                        if (isset($exanswer[1])){
                            $answer_score = str_replace(['(', ')'], '', $exanswer[1]);
                            $score+=$answer_score;
                            $scoreArr[$qVal['categoryId']][] = (int)$answer_score;
                        }
                    }
                    if ($qVal['type'] == 'SLIDER'){
                        $score+= (int)$answer;
                        $scoreArr[$qVal['categoryId']][] = (int)$answer;
                        $answer_score = $answer;
                    }
                    if($na==0){
                        $maxScore += ($qVal['max']??0);
                        $cateScoreArr[$qVal['categoryId']][] = (int)($qVal['max']??0);
                    }

//                    $category[$qVal['categoryId']] = $qVal['categoryName'];

                    $photos = $qVal['photo']??'';
                    $old_photo = $qVal['old_photo']??'';
                    $savedPhotos = [];
                    if (is_array($photos)) {
                        if($old_photo){
                            foreach ($old_photo as $oldImg){
                                $savedPhotos[] = $oldImg;
//                                deleteImage($oldImg, SURVEY_QUESTIONNAIRE_IMAGES_PATH);
                            }
                        }
                        foreach ($photos as $photo) {
                            // Only process files with no upload errors
                            $fileName = surveyUploadFile2($photo, SURVEY_QUESTIONNAIRE_IMAGES_PATH);
                            $savedPhotos[] = $fileName;
                        }
                    }else{
                        if($old_photo){
                            foreach ($old_photo as $oldImg){
                                $savedPhotos[] = $oldImg;
                            }
                        }
                    }

                    $input_type = 'input_type_'.$qId;
                    $question[$qVal['categoryId']][] = [
                        'qId' => $qId,
                        'title' => $qVal['title'],
                        'answer' => $answer??'',
                        'answer_image' => $answer_image??'',
                        'score' => $answer_score??0,
                        'max_score' => $qVal['max']??0,
                        'categoryName' => $qVal['categoryName'],
                        'comment_type' => $qVal['comment_type']??'',
                        'comment' => $qVal['comment']??'',
                        'photo' => $savedPhotos,
                        'na' => $qVal['na']??'0',
                        'qType' => $qVal['type'],
                    ];
                }
            }

            $scoreResult = $cateScoreResult = [];

            if(!empty($scoreArr)){
                foreach ($scoreArr as $key => $values) {
                    $scoreResult[$key] = array_sum($values);
                }
            }
            if(!empty($cateScoreArr)){
                foreach ($cateScoreArr as $cateKey => $cateValues) {
                    $cateScoreResult[$cateKey] = array_sum($cateValues);
                }
            }

            $response_data = [
                'title' => $request->title,
                'score' => $score,
                'max_score' => $maxScore,
                'score_result' => $scoreResult,
                'max_score_result' => $cateScoreResult,
                'question_id' => $id,
                'branch_id' => $request->branch_id,
                'category' => $category,
                'question' => $question,
            ];

            $saveData = [
                'visit_id' => $request->visit_id,
                'user_id' => $request->user_id,
                'response_data' => ($response_data),
                'total_score' => $score,
                'started_date' => ($request->started_date)? date('Y-m-d H:i',strtotime($request->started_date)) : null,
                'completed_date' => ($request->completed_date)? date('Y-m-d H:i',strtotime($request->completed_date)) : null,
            ];

            if(!$check || !$check->report_uid){
                do {
                    $unioqid = (string) Str::uuid();
                } while (VisitReport::where('report_uid', $unioqid)->exists());
                $saveData['report_uid'] = $unioqid;
            }
            if(!$check){
                VisitReport::create($saveData);
            }else{
                $check->update($saveData);
            }

            DB::commit();

            return $this->sendSuccess('questionnaire updated successfully!');
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError($exception->getMessage());
        }
    }

    public function questionnaireSubmit(Request $request)
    {
        try {
            DB::beginTransaction();

            $check = VisitReport::where(['visit_id' => $request->visit_id,'user_id' => $request->user_id])->first();

            if (!$check) {
                DB::rollBack();
                return $this->sendError('Visit report not found. Please try opening the questionnaire again.');
            }

            if (!$check->started_date || !$check->completed_date) {
                DB::rollBack();
                return $this->sendError('Please fill in the visit start and completion dates before submitting.');
            }

            $check->update(['status'=>'SUBMITTED']);
            Visit::find($request->visit_id)->update(['status'=>'PENDING']);

            DB::commit();
            return $this->sendSuccess('Questionnaire submitted successfully!');
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError('An error occurred while submitting the questionnaire: ' . $exception->getMessage(), 500);
        }
    }

    public function commentImage(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'visit_id' => 'required',
                'cat_id' => 'required',
                'id' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first());
            }

            $check =  VisitReport::where(['visit_id' => $request->visit_id])->first();
            if(gettype($check->response_data)=='array'){
                $response_data = $check->response_data;
            }else{
                $response_data = json_decode($check->response_data, true);
            }
            $question = $response_data['question'][$request->cat_id];
            $singleQuestion = collect($question)->firstWhere('qId', $request->id);

            return $this->sendSuccess(['photos'=>$singleQuestion['photo']??[]]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError($exception->getMessage());
        }
    }

    public function deleteCommentImage(Request $request)
    {
        try {
            $imagePath = $request->input('image'); // e.g. 'uploads/comments/img1.jpg'

            deleteImage($imagePath, SURVEY_QUESTIONNAIRE_IMAGES_PATH);

            return $this->sendSuccess('image deleted successfully!');
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError($exception->getMessage());
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

                $months = array_keys($result);
                $scores = $result;

                $newArr[$catName] = ['month'=>$months, 'score'=>$scores];
            }
        }

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
            'bar_logo' => public_path('assets/logo/Bitmap.png'),
            'visitData' => $visitData,
            'response_data' => $response_data,
            'chart_data' => $newArr,
        ];

        $pdf = PDF::loadView('admin.visit.reportPDF', $data);
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $canvas = $dompdf->getCanvas();

        $footer_company = "MysteryVisits.nl";
        $footer_phone = "tel: 024 234 28 13";
        $footer_email = "welkom@mysteryvisits.nl";

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

        return $pdf->stream('visit-'.$visit_id.'.pdf');
    }

    /**
     * Handle user expressing interest in a visit
     */
    public function request(Request $request)
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
            $userId = Auth::guard('web')->user()->id;

            // Check if user already expressed interest
            $existingInterest = VisitInterest::where('visit_id', $request->id)
                ->where('user_id', $userId)
                ->first();

            if ($existingInterest) {
                DB::rollBack();
                return $this->sendError('You have already expressed interest in this visit');
            }

            // Create interest record ONLY
            // DO NOT change visit status - it must remain OPEN
            // This allows other visitors to still see the visit
            VisitInterest::create([
                'visit_id' => $request->id,
                'user_id' => $userId,
                'status' => \App\Enums\InterestStatus::ACTIVE,
            ]);

            DB::commit();

            return $this->sendSuccess("Interest has been registered successfully");
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError($exception->getMessage(), 500);
        }
    }


    public function submissions(STRING $reportId)
    {
        $visitReport = VisitReport::where('report_uid', $reportId)->firstOrFail();

        if(gettype($visitReport->response_data)=='array'){
            $response_data = $visitReport->response_data;
        }else{
            $response_data = json_decode($visitReport->response_data, true);
        }

        return view('user.visit.view-submissions',compact('visitReport','response_data'));
    }

    public function visitCategory(String $reportId, String $categoryId)
    {
        $visitReport = VisitReport::where('report_uid', $reportId)->firstOrFail();

        if(gettype($visitReport->response_data)=='array'){
            $response_data = $visitReport->response_data;
        }else{
            $response_data = json_decode($visitReport->response_data, true);
        }
        $questions = $response_data['question'][$categoryId]??[];

        return view('user.visit.visit-category',compact('visitReport','response_data', 'categoryId', 'questions'));
    }

}
