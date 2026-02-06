<?php

namespace App\Models;

use App\Enums\InterestStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisitInterest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'visit_id',
        'user_id',
        'status',
    ];

    protected $casts     = [
        'status' => InterestStatus::class,
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
