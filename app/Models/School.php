<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'city',
        'address',
        'postal_code',
        'phone',
        'email',
        'website',
        'fields_of_study',
        'accreditations',
        'diplomas',
        'tuition_fee_min',
        'tuition_fee_max',
        'application_fee',
        'admission_requirements',
        'next_intake',
        'logo',
        'images',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fields_of_study' => 'array',
        'accreditations' => 'array',
        'diplomas' => 'array',
        'images' => 'array',
        'next_intake' => 'date',
        'tuition_fee_min' => 'decimal:2',
        'tuition_fee_max' => 'decimal:2',
        'application_fee' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the applications for the school.
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Scope a query to only include active schools.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Format tuition fee min in CFA.
     */
    public function getFormattedTuitionFeeMinAttribute()
    {
        return number_format($this->tuition_fee_min, 0, ',', ' ') . ' CFA';
    }

    /**
     * Format tuition fee max in CFA.
     */
    public function getFormattedTuitionFeeMaxAttribute()
    {
        return number_format($this->tuition_fee_max, 0, ',', ' ') . ' CFA';
    }

    /**
     * Format application fee in CFA.
     */
    public function getFormattedApplicationFeeAttribute()
    {
        return number_format($this->application_fee, 0, ',', ' ') . ' CFA';
    }

    /**
     * Get tuition fee range formatted in CFA.
     */
    public function getTuitionFeeRangeAttribute()
    {
        if ($this->tuition_fee_min == $this->tuition_fee_max) {
            return $this->formatted_tuition_fee_min;
        }
        return $this->formatted_tuition_fee_min . ' - ' . $this->formatted_tuition_fee_max;
    }


}
