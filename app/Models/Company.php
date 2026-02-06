<?php

namespace App\Models;

use App\Enums\CompanyStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Company extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'company_name',
        'image',
        'status',
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
        'status' => CompanyStatus::class,
    ];

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    public function company_users()
    {
        return $this->hasMany(CompanyUser::class);
    }

    public function getImageAttribute($value)
    {
        if (!$value) {
            return asset('assets/admin/images/users/user-dummy-img.jpg');
        }
        return asset(COMPANY_PROFILE_IMAGE_PATH . $value);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->company_id = (string) \Illuminate\Support\Str::uuid();
        });

        
    }
    public function subdealer()
    {
        return $this->belongsTo(Subdealer::class);
    }
}
