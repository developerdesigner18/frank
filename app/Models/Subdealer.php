<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subdealer extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'logo',
    ];

    public function getLogoAttribute($value)
    {
        if ($value) {
            return asset(SUBDEALER_LOGO_PATH . $value);
        }
        return null;
    }

    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
