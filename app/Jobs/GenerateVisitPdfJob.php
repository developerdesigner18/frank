<?php

namespace App\Jobs;

use App\Models\Visit;
use App\Models\VisitReport;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GenerateVisitPdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 600; // 10 minutes timeout
    public $tries = 3; // Retry 3 times if it fails

    protected $visitId;

    /**
     * Create a new job instance.
     */
    public function __construct($visitId)
    {
        $this->visitId = $visitId;
    }

    /**
     * Execute the job - Generate PDF in background
     */
    public function handle(): void
    {
        try {
            // Increase memory limit for PDF generation
            ini_set('memory_limit', '1024M');
            set_time_limit(600);

            Log::info("Starting PDF generation for visit ID: {$this->visitId}");

            $visitData = VisitReport::where(['visit_id' => $this->visitId])->first();

            if (!$visitData) {
                Log::error("Visit report not found for visit ID: {$this->visitId}");
                return;
            }

            // Prepare response data
            if (gettype($visitData->response_data) == 'array') {
                $response_data = $visitData->response_data;
            } else {
                $response_data = (array) json_decode($visitData->response_data);
            }

            // Calculate chart data
            $qVisitIds = $visitData->visit->questionnaire
                ->visits()
                ->whereIn('status', ['PENDING', 'COMPLETED'])
                ->pluck('id')
                ->toArray();

            $currentYear = Carbon::now()->year;
            $visitReports = VisitReport::whereIn('visit_id', $qVisitIds)
                ->whereYear('created_at', $currentYear)
                ->get();

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
            if ($minDate->month != $maxDate->month) {
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
                        $final_score = ($scores > 0) ? round(($scores / $max_scores) * 100, 2) : 0;

                        $result[$month] = $final_score;
                    }

                    $months = array_keys($result);
                    $scores = $result;

                    $newArr[$catName] = ['month' => $months, 'score' => $scores];
                }
            }

            // Logo and Footer logic - Priority: Branch > Company > Default
            // 1. Check if branch has a subdealer
            $subdealer = $visitData->visit->branch->subdealer ?? null;
            
            // 2. If no branch subdealer, check if company has a subdealer
            if (!$subdealer) {
                $subdealer = $visitData->visit->branch->company->subdealer ?? null;
            }
            
            $main_logo = public_path('assets/logo/bar_logo.png');

            if ($subdealer && $subdealer->getRawOriginal('logo')) {
                $logoPath = public_path(SUBDEALER_LOGO_PATH . $subdealer->getRawOriginal('logo'));
                if (file_exists($logoPath)) {
                    $main_logo = $logoPath;
                }
            }

            $data = [
                'title' => $response_data['title'] ?? 'Mystery Visit Report',
                'main_logo' => $main_logo,
                'bar_logo' => public_path('assets/logo/Bitmap.png'),
                'visitData' => $visitData,
                'response_data' => $response_data,
                'chart_data' => $newArr,
            ];

            // Generate PDF
            $pdf = PDF::loadView('admin.visit.reportPDF', $data);
            $pdf->output();
            $dompdf = $pdf->getDomPDF();
            $canvas = $dompdf->getCanvas();

            // Footer variables - Default to MysteryVisits.nl
            $footer_company = "MysteryVisits B.V.";
            $footer_phone = "tel: 024 234 28 13";
            $footer_email = "office@checkmijnzaak.nl";

            // Override with subdealer details if available
            if ($subdealer) {
                if ($subdealer->name) $footer_company = $subdealer->name;
                if ($subdealer->phone) $footer_phone = "tel: " . $subdealer->phone;
                if ($subdealer->email) $footer_email = $subdealer->email;
            }

            $branch_name = $visitData->visit->branch->branch_name ?? '';
            $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) use ($branch_name, $footer_company, $footer_phone, $footer_email) {
                $font = $fontMetrics->get_font("helvetica", "normal");
                $size = 9;

                $canvas->text(25, 815, $footer_company, $font, $size);
                $canvas->text(160, 815, $footer_phone, $font, $size);
                $canvas->text(278, 815, $footer_email, $font, $size);
                $canvas->text(425, 815, "$branch_name", $font, $size);
                $canvas->text(555, 815, "$pageNumber", $font, $size);
            });

            // Save PDF to storage
            $pdfDirectory = public_path(VISIT_PDF_PATH);
            if (!file_exists($pdfDirectory)) {
                mkdir($pdfDirectory, 0755, true);
            }

            $branch_name = $visitData->visit->branch->branch_name ?? 'Branch';
            $date = date('d-m-Y');
            $fileName = 'Mystery Visit ' . $branch_name . ' ' . $date . ' ' . time() . '.pdf';
            $filePath = $pdfDirectory . $fileName;

            // Save the PDF file (output() can only be called once!)
            $pdfContent = $pdf->output();
            file_put_contents($filePath, $pdfContent);

            // Update the visit report with PDF path
            $visitData->update([
                'report_pdf_url' => VISIT_PDF_PATH . $fileName
            ]);

            Log::info("PDF generated successfully for visit ID: {$this->visitId}, saved at: " . $filePath);

        } catch (\Exception $e) {
            Log::error("PDF generation failed for visit ID: {$this->visitId}. Error: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            throw $e; // Re-throw to trigger retry
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("PDF generation job failed permanently for visit ID: {$this->visitId}. Error: " . $exception->getMessage());
    }
}
