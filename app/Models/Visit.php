<?php

namespace App\Models;

use App\Enums\VisitStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'unioqid',
        'branch_id',
        'questionnaire_id',
        'start_datetime',
        'end_datetime',
        'price',
        'expense_estimation_min',
        'expense_estimation_max',
        'description',
        'status',
        'published',
        'visitor_id',
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'status' => VisitStatus::class,
        'price' => 'decimal:2',
        'expense_estimation_min' => 'decimal:2',
        'expense_estimation_max' => 'decimal:2',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class);
    }

    public function visitor()
    {
        return $this->belongsTo(User::class, 'visitor_id', 'id');
    }

    public function assignments()
    {
        return $this->hasMany(VisitAssignment::class);
    }

    public function interests()
    {
        return $this->hasMany(VisitInterest::class);
    }

    public function reports()
    {
        return $this->hasMany(VisitReport::class);
    }

    public function report()
    {
        return $this->hasOne(VisitReport::class);
    }
}
