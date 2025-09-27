<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'school_id',
        'field_of_study',
        'diploma_level',
        'motivation_letter',
        'documents',
        'status',
        'admin_notes',
        'commission_amount',
        'commission_paid',
        'submitted_at',
        'processed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'documents' => 'array',
        'commission_amount' => 'decimal:2',
        'commission_paid' => 'boolean',
        'submitted_at' => 'datetime',
        'processed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the application.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the school that the application belongs to.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Get the status badge color
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'submitted' => 'bg-blue-100 text-blue-800',
            'in_progress' => 'bg-yellow-100 text-yellow-800',
            'accepted' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Get the status label in French
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'submitted' => 'Soumise',
            'in_progress' => 'En cours',
            'accepted' => 'Acceptée',
            'rejected' => 'Rejetée',
            default => 'Inconnu'
        };
    }

    /**
     * Scope a query to only include pending applications.
     */
    public function scopePending($query)
    {
        return $query->whereIn('status', ['submitted', 'in_progress']);
    }

    /**
     * Scope a query to only include processed applications.
     */
    public function scopeProcessed($query)
    {
        return $query->whereIn('status', ['accepted', 'rejected']);
    }
}
