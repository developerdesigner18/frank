<?php

namespace App\Models;

use App\Enums\BranchRoutes;
use App\Enums\BranchStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'branches';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'branch_uid',
        'company_id',
        'subdealer_id',
        'branch_name',
        'image',
        'address_1',
        'locality',
        'postal_code',
        'upselling_input_url',
        'upselling_report_url',
        'input_url_46',
        'report_url_46',
        'route',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => BranchStatus::class,
        'route' => BranchRoutes::class,
    ];

    /**
     * Get the company that owns the branch.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function company_user(): BelongsTo
    {
        return $this->belongsTo(CompanyUser::class,'company_id','company_id');
    }

    public function subdealer(): BelongsTo
    {
        return $this->belongsTo(Subdealer::class);
    }

    public function contacts()
    {
        return $this->hasMany(BranchContact::class);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class,'branch_id','id');
    }

    public function getImageAttribute($value)
    {
        if (!$value) {
            return asset('assets/admin/images/users/user-dummy-img.jpg');
        }
        return asset(COMPANY_BRANCH_PROFILE_IMAGE_PATH . $value);
    }
}
