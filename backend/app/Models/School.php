<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'address',
        'city',
        'country',
        'phone',
        'email',
        'website',
        'logo',
        'banner_image',
        'established_year',
        'accreditations',
        'facilities',
        'admission_requirements',
        'application_fee',
        'is_active',
        'latitude',
        'longitude',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'accreditations' => 'array',
        'facilities' => 'array',
        'admission_requirements' => 'array',
        'application_fee' => 'decimal:2',
        'is_active' => 'boolean',
        'established_year' => 'integer',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Get the school's programs
     */
    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    /**
     * Get the school's applications
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Get the school's fees
     */
    public function fees()
    {
        return $this->hasMany(SchoolFee::class);
    }

    /**
     * Scope for active schools
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for schools by city
     */
    public function scopeByCity($query, $city)
    {
        return $query->where('city', 'like', '%' . $city . '%');
    }

    /**
     * Scope for schools by country
     */
    public function scopeByCountry($query, $country)
    {
        return $query->where('country', 'like', '%' . $country . '%');
    }

    /**
     * Scope for schools with specific accreditation
     */
    public function scopeWithAccreditation($query, $accreditation)
    {
        return $query->whereJsonContains('accreditations', $accreditation);
    }

    /**
     * Scope for schools within price range
     */
    public function scopeWithinPriceRange($query, $minPrice = null, $maxPrice = null)
    {
        if ($minPrice !== null) {
            $query->where('application_fee', '>=', $minPrice);
        }
        
        if ($maxPrice !== null) {
            $query->where('application_fee', '<=', $maxPrice);
        }
        
        return $query;
    }

    /**
     * Get total applications count
     */
    public function getTotalApplicationsAttribute()
    {
        return $this->applications()->count();
    }

    /**
     * Get pending applications count
     */
    public function getPendingApplicationsAttribute()
    {
        return $this->applications()->where('status', 'pending')->count();
    }

    /**
     * Get accepted applications count
     */
    public function getAcceptedApplicationsAttribute()
    {
        return $this->applications()->where('status', 'accepted')->count();
    }

    /**
     * Get total revenue from applications
     */
    public function getTotalRevenueAttribute()
    {
        return $this->applications()
            ->whereIn('status', ['accepted', 'in_progress'])
            ->sum('application_fee');
    }

    /**
     * Search schools by multiple criteria
     */
    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('name', 'like', '%' . $searchTerm . '%')
              ->orWhere('description', 'like', '%' . $searchTerm . '%')
              ->orWhere('city', 'like', '%' . $searchTerm . '%')
              ->orWhere('country', 'like', '%' . $searchTerm . '%');
        });
    }
}
