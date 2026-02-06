<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\RemunerationMethod;
use App\Enums\UserStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'uid',
        'first_name',
        'last_name',
        'email',
        'password',
        'mobile_number',
        'bank_account',
        'status',
        'remuneration_method',
        'profile_image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => UserStatus::class,
            'remuneration_method' => RemunerationMethod::class,
        ];
    }

    public function getProfileImageAttribute($value)
    {
        if (!$value) {
            return asset('assets/admin/images/users/user-dummy-img.jpg');
        }
        return asset(USER_PROFILE_IMAGE_PATH . $value);
    }
}
