<?php

namespace App\Http\Controllers;

use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalClinicians = User::where('role', 'Clinician')->count();
        $totalCaregivers = User::where('role', 'Caregiver')->count();
        $totalAdmins = User::where('role', 'Admin')->count();

        $recentUsers = User::latest()->take(5)->get();

        $clinicianPercentage = $totalUsers > 0 ? round(($totalClinicians / $totalUsers) * 100) : 0;
        $caregiverPercentage = $totalUsers > 0 ? round(($totalCaregivers / $totalUsers) * 100) : 0;

        return view('pages.dashboard', compact(
            'totalUsers',
            'totalClinicians',
            'totalCaregivers',
            'totalAdmins',
            'recentUsers',
            'clinicianPercentage',
            'caregiverPercentage'
        ));
    }
}