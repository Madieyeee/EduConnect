<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use HasFactory, SoftDeletes;

    const LEVEL_BACHELOR = 'bachelor';
    const LEVEL_MASTER = 'master';
    const LEVEL_PHD = 'phd';
    const LEVEL_DIPLOMA = 'diploma';
    const LEVEL_CERTIFICATE = 'certificate';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'school_id',
        'name',
        'description',
        'level',
        'duration_months',
        'tuition_fee',
        'currency',
        'requirements',
        'career_prospects',
        'is_active',
        'application_deadline',
        'start_date',
        'language_of_instruction',
        'mode_of_study', // full-time, part-time, online
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'requirements' => 'array',
        'career_prospects' => 'array',
        'tuition_fee' => 'decimal:2',
        'duration_months' => 'integer',
        'is_active' => 'boolean',
        'application_deadline' => 'date',
        'start_date' => 'date',
    ];

    /**
     * Get the school that owns the program
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Get the program's applications
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Scope for active programs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for programs by level
     */
    public function scopeByLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    /**
     * Scope for programs within tuition fee range
     */
    public function scopeWithinTuitionRange($query, $minFee = null, $maxFee = null)
    {
        if ($minFee !== null) {
            $query->where('tuition_fee', '>=', $minFee);
        }
        
        if ($maxFee !== null) {
            $query->where('tuition_fee', '<=', $maxFee);
        }
        
        return $query;
    }

    /**
     * Scope for programs by duration
     */
    public function scopeByDuration($query, $minMonths = null, $maxMonths = null)
    {
        if ($minMonths !== null) {
            $query->where('duration_months', '>=', $minMonths);
        }
        
        if ($maxMonths !== null) {
            $query->where('duration_months', '<=', $maxMonths);
        }
        
        return $query;
    }

    /**
     * Scope for programs by mode of study
     */
    public function scopeByMode($query, $mode)
    {
        return $query->where('mode_of_study', $mode);
    }

    /**
     * Search programs by name or description
     */
    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('name', 'like', '%' . $searchTerm . '%')
              ->orWhere('description', 'like', '%' . $searchTerm . '%');
        });
    }

    /**
     * Get duration in years
     */
    public function getDurationInYearsAttribute()
    {
        return round($this->duration_months / 12, 1);
    }

    /**
     * Get formatted tuition fee
     */
    public function getFormattedTuitionFeeAttribute()
    {
        return number_format($this->tuition_fee, 2) . ' ' . $this->currency;
    }

    /**
     * Check if application deadline has passed
     */
    public function getIsApplicationOpenAttribute()
    {
        return $this->application_deadline === null || 
               $this->application_deadline->isFuture();
    }

    /**
     * Get total applications count
     */
    public function getTotalApplicationsAttribute()
    {
        return $this->applications()->count();
    }

    /**
     * Get available levels
     */
    public static function getAvailableLevels()
    {
        return [
            self::LEVEL_CERTIFICATE => 'Certificate',
            self::LEVEL_DIPLOMA => 'Diploma',
            self::LEVEL_BACHELOR => 'Bachelor\'s Degree',
            self::LEVEL_MASTER => 'Master\'s Degree',
            self::LEVEL_PHD => 'PhD',
        ];
    }
}
