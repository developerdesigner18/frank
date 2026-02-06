<?php
//FOR GLOBAL FUNCTIONS

// Generate Filename
use App\Models\Visit;
use Carbon\Carbon;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\ImageManager;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Facades\File;

function fileName($ext, $prefix = "img_")
{
    return $prefix . now()->format('dmYHisv') . rand(100000, 999999) . '.' . $ext;
}

// Upload File
function uploadFile($file, $path, $prefix = "img_")
{

    $extension = $file->getClientOriginalExtension() != "" ? $file->getClientOriginalExtension() : $file->getExtension();
    $fileName = fileName($extension, $prefix);
    $file->move(public_path($path), $fileName);
    return $fileName;
}

function surveyUploadFile($file, $path, $prefix = "img_")
{
    $extension = $file->getClientOriginalExtension()??'jpg';
    $fileName = fileName($extension, $prefix);
    $file->move(public_path($path), $fileName);
    return $fileName;
}

function surveyUploadFile2($file, $path, $prefix = "img_")
{
    // Always save as WebP for better compression
    $fileName = fileName('webp', $prefix);
    $destinationPath = public_path($path);
    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0755, true);
    }

    $fullPath = $destinationPath . '/' . $fileName;

    // ✅ Image Optimization Solution (as per client request)
    // Automatically resize/compress photos to much smaller file size
    $manager = new ImageManager(new GdDriver());
    $image = $manager->read($file->getRealPath());

    // Get original dimensions
    $width = $image->width();
    $height = $image->height();

    // Maximum dimensions for report images (high resolution not needed)
    $maxWidth = 1920;
    $maxHeight = 1920;

    // Resize if image is larger than max dimensions (maintains aspect ratio)
    if ($width > $maxWidth || $height > $maxHeight) {
        $image->scale(width: $maxWidth, height: $maxHeight);
    }

    // Convert to WebP with 70% quality for optimal compression
    $image->toWebp(quality: 70);

    // Save image
    $image->save($fullPath);

    // Optional: Further optimize with Spatie
    if (class_exists(\Spatie\ImageOptimizer\OptimizerChainFactory::class)) {
        OptimizerChainFactory::create()->optimize($fullPath);
    }

    return $fileName;
}

function uploadFilepondEncodedFile($json, $path, $prefix = 'img_')
{

    $bannerJson = json_decode($json, true);

    $base64Image = base64_decode($bannerJson['data']);

    // Get extension from MIME type
    $mimeType = $bannerJson['type'];
    $extension = explode('/', $mimeType)[1];

    // Create ImageManager instance with driver (e.g., 'gd')
    $manager = new ImageManager(Driver::class);
    $image = $manager->read($base64Image); // Use `read()` instead of `make()`

    $tempPath = tempnam(sys_get_temp_dir(), $prefix);
    $tempPathWithExt = $tempPath . '.' . $extension;
    $image->save($tempPathWithExt);


    $uploadedFile = new \Illuminate\Http\File($tempPathWithExt);
    $fileName = uploadFile($uploadedFile, $path, $prefix);
    unlink($tempPath);

    return $fileName;
}

function deleteImage($file,$path){
    $filepath = public_path($path).basename($file);
    if(File::exists($filepath)) {
        File::delete($filepath);
        return true;
    }
    return false;
}

// To use carbon in blade file
function carbon()
{
    return new Carbon();
}

// Convert time to human readable format
function dateToHuman($date, $format = 'Y-m-d H:i:s', $timezone = "UTC")
{
    try {
        if (!empty($date)) {
            return Carbon::parse($date, "UTC")
                ->tz($timezone)
                ->format($format);
        } else {
            return "N/A";
        }
    } catch (Exception $exception) {
        return "N/A";
    }
}

// Get Dates Between
function getDatesBetween($start, $end)
{
    $date = Carbon::parse($start);
    $endDate = Carbon::parse($end);
    $dateArray = [];
    while ($date->lte($endDate)) {
        array_push($dateArray, $date->format('Y-m-d'));
        $date->addDay();
    }
    return $dateArray;
}

// Find Nearest WeekDay Date
function nearestWeekDate($today, $days)
{
    $today = Carbon::parse($today)->addDay();
    $todayWeekDay = strtoupper($today->format('l'));
    $nearestDay = $today;

    while (!in_array($todayWeekDay, $days)) {
        $nearestDay = $today;
        $today->addDay();
        $todayWeekDay = strtoupper($today->format('l'));
    }

    return $nearestDay;
}

function checkMulitCompany()
{
    $auth = \Illuminate\Support\Facades\Auth::guard('company')->user();

    $companyUsers = \App\Models\CompanyUser::where('email', $auth->email)->get()->count();

    return $companyUsers;
}

function getCompanyProfile()
{
    $auth = \Illuminate\Support\Facades\Auth::guard('company')->user();
    $companyUsers = \App\Models\CompanyUser::where('email', $auth->email)->get();
    return $companyUsers;
}

function currency_icon()
{
    return '€';
}

function getVisitCounts($user_id = ""): array
{
    return [
        'available' => Visit::where('status', 'OPEN')
            ->when($user_id, function($q) use ($user_id) {
                // Visitor: Exclude visits where this user has expressed interest
                $q->whereDoesntHave('interests', function($subQuery) use ($user_id) {
                    $subQuery->where('user_id', $user_id);
                });
            }, function($q) {
                // Admin: Exclude visits with ANY interests
                $q->whereDoesntHave('interests');
            })
            ->count(),

        'interested' => $user_id
            ? \App\Models\VisitInterest::where('user_id', $user_id)
                ->whereHas('visit', function ($q) {
                    $q->where('status', 'OPEN')
                      ->orWhere('status', 'INTERESTED');
                })->count()
            : Visit::whereHas('interests')->where(function($q) {
                $q->where('status', 'OPEN')
                    ->orWhere('status', 'INTERESTED');
            })->count(), // Admin: count visits with any interests

        'scheduled' => Visit::where(function($query) {
            $query->where('status', 'IN_PROGRESS')
                ->orWhere('status', 'SCHEDULED')
                ->orWhere('status', 'ASSIGNED');
        })
            ->when($user_id, fn($q) => $q->where('visitor_id', $user_id))
            ->count(),

        'pending' => Visit::where('status', 'PENDING')
            ->when($user_id, fn($q) => $q->where('visitor_id', $user_id))
            ->count(),

        'completed' => Visit::where('status', 'COMPLETED')
            ->when($user_id, fn($q) => $q->where('visitor_id', $user_id))
            ->count(),

        'all' => Visit::when($user_id, fn($q) => $q->where('visitor_id', $user_id))
            ->count(),
    ];
}

/**
 * Get translated message from messages.php file
 *
 * @param string $key Translation key
 * @param array $replace Replacement values
 * @param string|null $locale Specific locale (optional)
 * @return string Translated message
 */
function trans_message($key, $replace = [], $locale = null)
{
    return __('messages.' . $key, $replace, $locale);
}

/**
 * Get current application locale
 *
 * @return string Current locale (en, nl, etc.)
 */
function get_current_locale()
{
    return app()->getLocale();
}

/**
 * Check if current locale is specific language
 *
 * @param string $locale Locale to check
 * @return bool
 */
function is_locale($locale)
{
    return get_current_locale() === $locale;
}

/**
 * Calculate total reimbursement amount from AMOUNT type questions in visit report
 *
 * @param mixed $responseData The response_data from visit_reports table (can be array or JSON string)
 * @return float Total reimbursement amount
 */
function calculateReimbursementAmount($responseData)
{
    try {
        // Convert JSON string to array
        if (is_string($responseData)) {
            $responseData = json_decode($responseData, true);
        }

        if (!is_array($responseData)) {
            return 0.00;
        }

        $lastAmount = 0.00;

        if (isset($responseData['question']) && is_array($responseData['question'])) {
            foreach ($responseData['question'] as $categoryQuestions) {
                if (!is_array($categoryQuestions)) {
                    continue;
                }

                foreach ($categoryQuestions as $question) {
                    if (
                        ($question['qType'] ?? '') === 'AMOUNT' &&
                        isset($question['answer']) &&
                        is_numeric($question['answer'])
                    ) {
                        // Always overwrite → last AMOUNT wins
                        $lastAmount = (float)$question['answer'];
                    }
                }
            }
        }

        return round($lastAmount, 2);

    } catch (\Exception $e) {
        \Log::error('Error calculating reimbursement amount: ' . $e->getMessage());
        return 0.00;
    }
}
