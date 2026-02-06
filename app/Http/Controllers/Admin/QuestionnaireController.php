<?php

namespace App\Http\Controllers\Admin;

use App\Enums\QuestionnaireStatus;
use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Questionnaire;
use App\Models\Visit;
use App\Models\VisitReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class QuestionnaireController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        return view('admin.questionnaire.index');
    }

    public function list(Request $request)
    {

        try {
            $query = Questionnaire::query();

            // Filter by status - handle Enum casting
            if ($request->filled('status')) {
                // Convert string to Enum instance for proper comparison
                try {
                    $statusEnum = QuestionnaireStatus::from($request->status);
                    $query->where('status', $statusEnum);
                  
                } catch (\ValueError $e) {
                    // Invalid status value, skip filter
                }
            }
else{
$query->whereIn('status', [
    QuestionnaireStatus::DRAFT->value,
    QuestionnaireStatus::ACTIVE->value,
]);}
            // Sort by
            if ($request->sort_by) {
            
                $query->orderBy('id', $request->sort_by);
            }else{
                     
                $query->orderBy('id', 'asc');
             
            }

            $resultData = $query->get();
            $html = view('admin.questionnaire.list', compact('resultData'))->render();
            return $this->sendSuccess($html);
        } catch (\Exception $exception) {
            // Log the actual error for debugging
            \Log::error('Questionnaire list error: ' . $exception->getMessage(), [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTraceAsString()
            ]);
            return $this->sendDataTableError($exception->getMessage(), [], 500);
        }
    }

    public function duplicate(Request $request)
    {
        // dd($request->all());
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            DB::beginTransaction();

            $questionnaire = Questionnaire::find($request->id);

            // Replicate (clone) the visit
            $newQuestionnaire = $questionnaire->replicate();
  $quid = (string) Str::uuid();
            // Optionally change fields
            $newQuestionnaire->quid = $quid;
            $newQuestionnaire->status = QuestionnaireStatus::DRAFT->value;
            $newQuestionnaire->name = $request->name;
            $newQuestionnaire->is_published = 0;
            $newQuestionnaire->created_at = now();
            $newQuestionnaire->updated_at = now();

            // Save the new visit
            $newQuestionnaire->save();
            DB::commit();
            return $this->sendSuccess("Questionnaire has been duplicated successfully");
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:questionnaires,id',
            ]);
            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $company = Questionnaire::find($request->id);

            $company->delete();

            return $this->sendSuccess("Questionnaires has been removed successfully");

        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function statusUpdate(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:questionnaires,id',
            ]);
            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $company = Questionnaire::find($request->id);
            $company->status = $request->status;
            if($request->status==QuestionnaireStatus::ACTIVE->value){
                $company->is_published=1;
            }
            else{
                $company->is_published=0;
            }
            $company->update();

            return $this->sendSuccess("status updated successfully");

        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function addForm(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:questionnaires,name',
            ]);
            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }


            DB::beginTransaction();

            $que = new Questionnaire();
            do {
                $quid = (string) Str::uuid();
            } while (Questionnaire::where('quid', $quid)->exists());

            $que->quid = $quid;
            $que->name = $request->name;
            $que->status = QuestionnaireStatus::DRAFT->value;

            $payload = [
                'title' => $request->name,
                'categories' => [
                    [
                        'id' => 'default',
                        'name' => 'General',
                    ]
                ]
            ];
            $que->payload = json_encode($payload);
            $que->save();

            DB::commit();

            return $this->sendResponse('questionnaire generated successfully!',$quid);

        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function form($quid)
    {

        $questionnaire = Questionnaire::where('quid','=',$quid)->first();
        $questionnaireId = $questionnaire->id;
        $payload = json_decode($questionnaire->payload,true);
        return view('admin.questionnaire.form', compact('questionnaireId','questionnaire', 'payload'));
    }

    public function rename(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:questionnaires,id',
                'name' => [
                    'required',
                    Rule::unique('questionnaires', 'name')->ignore($request->id),
                ],
            ]);
            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }
            DB::beginTransaction();
            $ques = Questionnaire::find($request->id);
            $ques->name = $request->name;
            $ques->save();
            DB::commit();
            return $this->sendResponse("name has been rename successfully",$request->name);

        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function edit($id)
    {
        $questionnaire = Questionnaire::find($id);
        return view('admin.questionnaire.edit', compact('questionnaire'));
    }

    public function save(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'payload' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        try {
            DB::beginTransaction();

            $que = new Questionnaire();
            $que->name = $request->title;
            $que->payload = $request->payload;
            $que->status = QuestionnaireStatus::ACTIVE;
            $que->save();

            DB::commit();

            return $this->sendSuccess('questionnaire generated successfully!');
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError($exception->getMessage());
        }

    }

    public function clone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:questionnaires,id',
            'title' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        try {
            DB::beginTransaction();

            $que = Questionnaire::find($request->id);

            $newQue = new Questionnaire();
            $newQue->name = $request->title;
            $newQue->status = $que->status;
            $newQue->payload = $que->payload;
            $newQue->is_published = $que->is_published;
            $newQue->save();

            DB::commit();
            return $this->sendSuccess('questionnaire cloned successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError($exception->getMessage());
        }
    }

    public function uploadImages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        try {
            $fileName = uploadFile($request->image, QUESTIONNAIRE_IMAGES_PATH);
            return $this->sendResponse('success', ['imageUrl' => asset(QUESTIONNAIRE_IMAGES_PATH . $fileName)]);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }
    }



    public function updateStatus(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:questionnaires,id',
                'status' => ['required', Rule::in(array_column(QuestionnaireStatus::cases(), 'value'))]
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $company = Questionnaire::find($request->id);
            $company->status = QuestionnaireStatus::from($request->status);
            $company->save();

            return $this->sendSuccess("Questionnaire status updated successfully");

        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function changePublish(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:questionnaires,id',
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $company = Questionnaire::find($request->id);

            $company->is_published = $request->status;
            $company->save();

            return $this->sendSuccess($request->status==1?"Questionnaire Publish successfully!":"Questionnaire save draft successfully");

        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }


    // Category CRUD Methods
    public function addCategory(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'questionnaire_id' => 'required|exists:questionnaires,id',
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            DB::beginTransaction();

            $questionnaire = Questionnaire::find($request->questionnaire_id);
            $payload = json_decode($questionnaire->payload, true);

            // Generate unique ID for category
            $categoryId = (string) mt_rand(10000000, 9999999999);

            // Handle image upload
            $imageUrl = null;
            if ($request->hasFile('image')) {
                $fileName = uploadFile($request->image, QUESTIONNAIRE_IMAGES_PATH,'cate_');
                $imageUrl = asset(QUESTIONNAIRE_IMAGES_PATH . $fileName);
            }

            // Add new category to payload
            $newCategory = [
                'id' => $categoryId,
                'name' => $request->name,
                'imageUrl' => $imageUrl
            ];

            if (!isset($payload['categories'])) {
                $payload['categories'] = [];
            }
            $payload['categories'][] = $newCategory;

            $questionnaire->payload = json_encode($payload);
            $questionnaire->save();

            DB::commit();

            return $this->sendResponse('Category added successfully', $newCategory);

        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function editCategory(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'questionnaire_id' => 'required|exists:questionnaires,id',
                'category_id' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $questionnaire = Questionnaire::find($request->questionnaire_id);
            $payload = json_decode($questionnaire->payload, true);

            if (!isset($payload['categories'])) {
                return $this->sendError('No categories found');
            }

            $category = collect($payload['categories'])->firstWhere('id', $request->category_id);

            if (!$category) {
                return $this->sendError('Category not found');
            }

            return $this->sendResponse('Category retrieved successfully', $category);

        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function updateCategory(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'questionnaire_id' => 'required|exists:questionnaires,id',
                'category_id' => 'required|string',
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'remove_image' => 'nullable|in:0,1'
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            DB::beginTransaction();

            $questionnaire = Questionnaire::find($request->questionnaire_id);
            $payload = json_decode($questionnaire->payload, true);

            if (!isset($payload['categories'])) {
                return $this->sendError('No categories found');
            }

            $categoryIndex = collect($payload['categories'])->search(function ($category) use ($request) {
                return $category['id'] === $request->category_id;
            });

            if ($categoryIndex === false) {
                return $this->sendError('Category not found');
            }

            // Handle image operations
            $imageUrl = $payload['categories'][$categoryIndex]['imageUrl'] ?? null;

            // Check if user wants to remove the image
            if ($request->input('remove_image') == '1') {
                // Delete the old image if exists
                if (!empty($imageUrl)) {
                    $parsedUrl = parse_url($imageUrl, PHP_URL_PATH);
                    $imagePath = public_path($parsedUrl);
                    if (file_exists($imagePath)) {
                        @unlink($imagePath);
                    }
                }
                $imageUrl = null; // Set to null to remove from payload
            }
            // Check if new image is uploaded
            elseif ($request->hasFile('image')) {
                // Unlink old image if exists
                if (!empty($imageUrl)) {
                    $parsedUrl = parse_url($imageUrl, PHP_URL_PATH);
                    $imagePath = public_path($parsedUrl);
                    if (file_exists($imagePath)) {
                        @unlink($imagePath);
                    }
                }
                $fileName = uploadFile($request->image, QUESTIONNAIRE_IMAGES_PATH,'cate_');
                $imageUrl = asset(QUESTIONNAIRE_IMAGES_PATH . $fileName);
            }
            // Otherwise, keep the existing imageUrl

            // Update category
            $payload['categories'][$categoryIndex]['name'] = $request->name;
            $payload['categories'][$categoryIndex]['imageUrl'] = $imageUrl;

            $questionnaire->payload = json_encode($payload);
            $questionnaire->save();

            DB::commit();

            return $this->sendResponse('Category updated successfully', $payload['categories'][$categoryIndex]);

        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function deleteCategory(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'questionnaire_id' => 'required|exists:questionnaires,id',
                'category_id' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            DB::beginTransaction();

            $questionnaire = Questionnaire::find($request->questionnaire_id);
            $payload = json_decode($questionnaire->payload, true);

            if (!isset($payload['categories'])) {
                return $this->sendError('No categories found');
            }

            // Find the category to delete and unlink its image if exists
            $categoryToDelete = null;
            foreach ($payload['categories'] as $category) {
                if ($category['id'] === $request->category_id) {
                    $categoryToDelete = $category;
                    break;
                }
            }

            if ($categoryToDelete && !empty($categoryToDelete['imageUrl'])) {
                // Extract the file path from the imageUrl
                $imageUrl = $categoryToDelete['imageUrl'];
                $parsedUrl = parse_url($imageUrl, PHP_URL_PATH);
                $imagePath = public_path($parsedUrl);

                if (file_exists($imagePath)) {
                    @unlink($imagePath);
                }
            }

            // Remove category from payload
            $payload['categories'] = array_filter($payload['categories'], function ($category) use ($request) {
                return $category['id'] !== $request->category_id;
            });

            // Re-index array
            $payload['categories'] = array_values($payload['categories']);

            $questionnaire->payload = json_encode($payload);
            $questionnaire->save();

            DB::commit();

            return $this->sendSuccess('Category deleted successfully');

        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError(ERROR_500, 500);
        }
    }

    public function listCategories(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'questionnaire_id' => 'required|exists:questionnaires,id',
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $questionnaire = Questionnaire::find($request->questionnaire_id);
            $payload = json_decode($questionnaire->payload, true);

            $categories = $payload['categories'] ?? [];

            return $this->sendResponse('Categories retrieved successfully', $categories);

        } catch (\Exception $exception) {
            return $this->sendError(ERROR_500, 500);
        }
    }


    public function getQuestionsByCategory(Request $request, $id)
    {

        try {
            $questionnaire = Questionnaire::find($id);
            $payload = json_decode($questionnaire->payload, true);

            $categoryId = $request->category_id;

            $filteredCategory = [];
            if(isset($payload['categories'])){
                foreach ($payload['categories'] as $category){
                    if(($category['id'] ?? 'default') === $categoryId){
                        $filteredCategory = $category;
                    }
                }
            }
            $filteredCategory = (isset($filteredCategory) && count($filteredCategory)>0)?$filteredCategory:[];
            $questions = [];
            if(isset($filteredCategory['questions']) && count($filteredCategory['questions'])>0){
                $questions = $filteredCategory['questions'];
            }

            return $this->sendResponse('questionnaire listed.',['payload' => $payload, 'filteredCategory'=>$filteredCategory , 'questions'=>$questions]);

        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }
    }

    public function addNewQuestion(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        try {
            DB::beginTransaction();

            $que = Questionnaire::find($id);
            $qus_id = $request->qus_id??'';

            $newQuestion = [
                "id" => (string) random_int(100000, 90000000),
                "categoryId" => $request->category_id,
                "type" => "RADIO",
                "title" => "Question",
                "required" => '0',
                "comment" => null,
                "imageUrl" => null,
                "options" => [
                    [
                        "text" => null,
                        "score" => null,
                    ]
                ]
            ];

            $array2 = json_decode($que->payload, true);

            // If qus_id is given → copy details
            if ($qus_id) {
                foreach ($array2['categories'] as $category) {
                    if (isset($category['questions']) && is_array($category['questions'])) {
                        foreach ($category['questions'] as $question) {
                            if ($question['id'] == $qus_id) {
                                $newQuestion['type'] = $question['type'] ?? $newQuestion['type'];
                                $newQuestion['title'] = $question['title'] ?? $newQuestion['title'];
                                $newQuestion['required'] = $question['required'] ?? $newQuestion['required'];
                                $newQuestion['comment'] = $question['comment'] ?? $newQuestion['comment'];
                                $newQuestion['options'] = $question['options'] ?? $newQuestion['options'];
                                break 2; // stop once found
                            }
                        }
                    }
                }
            }

            foreach ($array2['categories'] as &$category) {
                if ($category['id'] === $request->category_id) {
                    if (!isset($category['questions']) || !is_array($category['questions'])) {
                        $category['questions'] = [];
                    }
                    $category['questions'][] = $newQuestion;
                }
            }
            unset($category);
            $que->payload = $array2;
            $que->save();

            DB::commit();

            return $this->sendSuccess('Question added successfully!');
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError($exception->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'current_category_id' => 'required',
            'payload' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        try {
            DB::beginTransaction();

            $que = Questionnaire::find($id);

            $category_id = $request->current_category_id;

            $array1 = $request->payload;
            $array2 = json_decode($que->payload, true);
            
            // Update ALL categories from the request, not just the current one
            // This preserves the category order when drag-and-drop reordering occurs
            if (isset($array1['categories']) && is_array($array1['categories'])) {
                // Create a map of existing categories by ID for quick lookup
                $existingCategoriesMap = [];
                if (isset($array2['categories'])) {
                    foreach ($array2['categories'] as $cat) {
                        $existingCategoriesMap[$cat['id']] = $cat;
                    }
                }
                
                // Update the categories array with the new order from the request
                $updatedCategories = [];
                foreach ($array1['categories'] as $cat1) {
                    $catId = $cat1['id'];
                    
                    // If this is the current category, use the full data from the request
                    if ($catId === $category_id) {
                        // BUT preserve imageUrl from existing data if not in request
                        if (!isset($cat1['imageUrl']) && isset($existingCategoriesMap[$catId]['imageUrl'])) {
                            $cat1['imageUrl'] = $existingCategoriesMap[$catId]['imageUrl'];
                        }
                        $updatedCategories[] = $cat1;
                    }
                    // Otherwise, preserve the existing category data but in the new position
                    elseif (isset($existingCategoriesMap[$catId])) {
                        // Merge: keep existing data but update name if provided
                        $mergedCategory = $existingCategoriesMap[$catId];
                        if (isset($cat1['name'])) {
                            $mergedCategory['name'] = $cat1['name'];
                        }
                        // CRITICAL: Always preserve imageUrl from database
                        if (isset($existingCategoriesMap[$catId]['imageUrl'])) {
                            $mergedCategory['imageUrl'] = $existingCategoriesMap[$catId]['imageUrl'];
                        }
                        $updatedCategories[] = $mergedCategory;
                    }
                    // If it's a new category (shouldn't happen in update, but just in case)
                    else {
                        // Ensure imageUrl is set to null if not provided
                        if (!isset($cat1['imageUrl'])) {
                            $cat1['imageUrl'] = null;
                        }
                        $updatedCategories[] = $cat1;
                    }
                }
                
                // Replace the categories array with the updated one
                $array2['categories'] = $updatedCategories;
            }
            
            $que->payload = $array2;
            $que->save();

            DB::commit();

            return $this->sendSuccess('questionnaire updated successfully!');
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError($exception->getMessage());
        }
    }

    // View Questionnaires CRUD

    public function viewQuestionnaires($quid)
    {
        $questionnaire = Questionnaire::where('quid','=',$quid)->first();
        $questionnaireId = $questionnaire->id;
        $payload = json_decode($questionnaire->payload,true);
//        dd($payload);
        return view('admin.questionnaire.view', compact('questionnaireId','questionnaire', 'payload'));
    }


    public function questionnaireResponse($visitId)
    {
        $visit = Visit::with(['branch', 'questionnaire'])->where('unioqid','=',$visitId)->first();
        $visit_id = $visit->id;
        if(!$visit){
            return redirect()->route('admin.visit.index');
        }
        $visit_report_data =  VisitReport::where(['visit_id' => $visit_id])->first();

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

        return view('admin.visit.response',compact('visit','questionnaire', 'payload', 'visit_report_data', 'old_questions'));
    }

    public function questionnaireResponseUpdate(Request $request, $id)
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
                        $old_photos = (!empty($report_result) && $report_result['photo'])?$report_result['photo']:[];
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
                // ✅ If an old PDF exists, delete it so the next generate/download call picks up the new data
                if ($check->report_pdf_url && file_exists(public_path($check->report_pdf_url))) {
                    @unlink(public_path($check->report_pdf_url));
                }
                $saveData['report_pdf_url'] = null; // Mark as needs regeneration
                $check->update($saveData);
            }

            DB::commit();

            return $this->sendSuccess('questionnaire updated successfully!');
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError($exception->getMessage());
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

    public function questionnaireResponseSubmit(Request $request)
    {
        try {
            DB::beginTransaction();

            $check =  VisitReport::where(['visit_id' => $request->visit_id])->first();

            if(!$check->started_date || !$check->completed_date){
                return $this->sendError('Date not found!');
            }

            $check->update(['status'=>'SUBMITTED']);
            Visit::find($request->visit_id)->update(['status'=>'PENDING']);

            DB::commit();
            return $this->sendSuccess('questionnaire submit successfully!');
        } catch (\Exception $exception) {
            return $this->sendDataTableError(ERROR_500, [], 500);
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
}
