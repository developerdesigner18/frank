<?php

namespace App\Models;

use App\Enums\QuestionnaireStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Questionnaire extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'status',
        'payload',
        'is_published',
    ];

    protected $casts = [
        'status' => QuestionnaireStatus::class,
        'is_published' => 'boolean',
    ];

    protected $appends = ['total_que_count'];

    public function getTotalQueCountAttribute()
    {
        return  $this->payload ? count(json_decode($this->payload,true)['questions']) : 0;
    }

    public function visits():HasMany
    {
        return $this->hasMany(Visit::class,'questionnaire_id','id');
    }
}
