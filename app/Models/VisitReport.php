<?php

namespace App\Models;

use App\Enums\ReportStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisitReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'report_uid',
        'visit_id',
        'user_id',
        'photos',
        'total_score',
        'status',
        'report_pdf_url',
        'admin_notes',
        'started_date',
        'completed_date',
        'response_data',
        'price_paid',
        'reimbursement_paid',
    ];

    protected $casts = [
        'status' => ReportStatus::class,
        'response_data' => 'array',
        'photos' => 'array',
        'total_score' => 'decimal:2',
    ];

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
