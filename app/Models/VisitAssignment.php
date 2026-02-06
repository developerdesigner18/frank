<?php

namespace App\Models;

use App\Enums\AssignmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisitAssignment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'visit_id',
        'user_id',
        'status',
    ];

    protected $casts = [
        'status' => AssignmentStatus::class,
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
