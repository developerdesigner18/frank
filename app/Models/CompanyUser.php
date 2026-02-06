<?php

namespace App\Models;

use App\Enums\CompanyStatus;
use App\Enums\CompanyUserStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CompanyUser extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cuid',
        'name',
        'email',
        'mobile_number',
        'image',
        'status',
        'company_id',
        'password',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'status' => CompanyUserStatus::class,
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class,'company_id','company_id');
    }

    public function getImageAttribute($value)
    {
        if (!$value) {
            return asset('assets/admin/images/users/user-dummy-img.jpg');
        }
        return asset(COMPANY_USER_PROFILE_IMAGE_PATH . $value);
    }
}
