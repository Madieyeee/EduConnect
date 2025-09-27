<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application homepage.
     */
    public function index()
    {
        $featuredSchools = School::active()
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact('featuredSchools'));
    }

    /**
     * Show the schools search page.
     */
    public function schools(Request $request)
    {
        $query = School::active();

        // Search filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', "%{$request->city}%");
        }

        if ($request->filled('field')) {
            $query->whereJsonContains('fields_of_study', $request->field);
        }

        if ($request->filled('diploma')) {
            $query->whereJsonContains('diplomas', $request->diploma);
        }

        if ($request->filled('max_fee')) {
            $query->where('tuition_fee_max', '<=', $request->max_fee);
        }

        $schools = $query->paginate(12)->withQueryString();

        // Get unique cities and fields for filters
        $cities = School::active()->distinct()->pluck('city')->sort();
        $allFields = School::active()->get()->pluck('fields_of_study')->flatten()->unique()->sort();
        $allDiplomas = School::active()->get()->pluck('diplomas')->flatten()->unique()->sort();

        return view('schools.index', compact('schools', 'cities', 'allFields', 'allDiplomas'));
    }

    /**
     * Show a specific school.
     */
    public function showSchool(School $school)
    {
        if (!$school->is_active) {
            abort(404);
        }

        return view('schools.show', compact('school'));
    }
}
