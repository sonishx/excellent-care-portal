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
        $totalMessages = \App\Models\Message::count();
        $totalDocuments = \App\Models\Document::count();
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
            'caregiverPercentage','totalMessages', 'totalDocuments'
        ));
    }
    public function exportData()
{
    $filename = 'user_data.csv'; // CSV filename
    $users = \App\Models\User::all(); // Fetch all users

    // Set CSV headers
    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$filename",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    ];

    $columns = ['ID', 'Name', 'Email', 'Role'];

    $callback = function() use ($users, $columns) {
        $file = fopen('php://output', 'w');
        // Add column headers
        fputcsv($file, $columns);

        // Add user data rows
        foreach ($users as $user) {
            fputcsv($file, [
                $user->id,
                $user->name,
                $user->email,
                $user->role ?? 'N/A'
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
}
