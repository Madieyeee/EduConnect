<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_SUBMITTED = 'submitted';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_REJECTED = 'rejected';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'school_id',
        'program_id',
        'application_number',
        'status',
        'application_fee',
        'payment_status',
        'payment_reference',
        'documents',
        'personal_statement',
        'academic_background',
        'work_experience',
        'references',
        'submitted_at',
        'reviewed_at',
        'decision_date',
        'admin_notes',
        'rejection_reason',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'documents' => 'array',
        'academic_background' => 'array',
        'work_experience' => 'array',
        'references' => 'array',
        'application_fee' => 'decimal:2',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'decision_date' => 'datetime',
    ];

    /**
     * Get the user that owns the application
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the school for this application
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Get the program for this application
     */
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Scope for applications by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for submitted applications
     */
    public function scopeSubmitted($query)
    {
        return $query->where('status', self::STATUS_SUBMITTED);
    }

    /**
     * Scope for in progress applications
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', self::STATUS_IN_PROGRESS);
    }

    /**
     * Scope for accepted applications
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', self::STATUS_ACCEPTED);
    }

    /**
     * Scope for rejected applications
     */
    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    /**
     * Scope for applications by school
     */
    public function scopeBySchool($query, $schoolId)
    {
        return $query->where('school_id', $schoolId);
    }

    /**
     * Scope for applications by program
     */
    public function scopeByProgram($query, $programId)
    {
        return $query->where('program_id', $programId);
    }

    /**
     * Scope for paid applications
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    /**
     * Generate unique application number
     */
    public static function generateApplicationNumber()
    {
        $year = date('Y');
        $lastApplication = self::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();
        
        $sequence = $lastApplication ? 
            intval(substr($lastApplication->application_number, -4)) + 1 : 1;
        
        return 'APP' . $year . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Boot method to generate application number
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($application) {
            if (empty($application->application_number)) {
                $application->application_number = self::generateApplicationNumber();
            }
        });
    }

    /**
     * Check if application is editable
     */
    public function getIsEditableAttribute()
    {
        return in_array($this->status, [self::STATUS_SUBMITTED]);
    }

    /**
     * Check if application can be withdrawn
     */
    public function getCanWithdrawAttribute()
    {
        return in_array($this->status, [self::STATUS_SUBMITTED, self::STATUS_IN_PROGRESS]);
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            self::STATUS_SUBMITTED => 'Soumise',
            self::STATUS_IN_PROGRESS => 'En cours',
            self::STATUS_ACCEPTED => 'Acceptée',
            self::STATUS_REJECTED => 'Rejetée',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    /**
     * Get status color for UI
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            self::STATUS_SUBMITTED => 'blue',
            self::STATUS_IN_PROGRESS => 'yellow',
            self::STATUS_ACCEPTED => 'green',
            self::STATUS_REJECTED => 'red',
        ];

        return $colors[$this->status] ?? 'gray';
    }

    /**
     * Get available statuses
     */
    public static function getAvailableStatuses()
    {
        return [
            self::STATUS_SUBMITTED => 'Soumise',
            self::STATUS_IN_PROGRESS => 'En cours',
            self::STATUS_ACCEPTED => 'Acceptée',
            self::STATUS_REJECTED => 'Rejetée',
        ];
    }

    /**
     * Update status with timestamp
     */
    public function updateStatus($status, $adminNotes = null)
    {
        $this->status = $status;
        $this->admin_notes = $adminNotes;
        
        if ($status === self::STATUS_IN_PROGRESS && !$this->reviewed_at) {
            $this->reviewed_at = now();
        }
        
        if (in_array($status, [self::STATUS_ACCEPTED, self::STATUS_REJECTED])) {
            $this->decision_date = now();
        }
        
        $this->save();
    }
}
