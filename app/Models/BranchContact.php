<?php

namespace App\Models;

use App\Enums\BranchContactStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchContact extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'branch_id',
        'first_name',
        'last_name',
        'email',
        'mobile_number',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => BranchContactStatus::class,
    ];

    /**
     * Get the branch that owns the contact.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
