<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- required for DB queries
use Carbon\Carbon; // <-- required for Carbon date handling
use App\Models\User;
use App\Models\ChatMessage; // if used for messages
use App\Models\Document; // if used for documents

class DashboardController extends Controller
{
    public function index()
    {
        // Example: last 12 days active users
        $activity = DB::table('user_activity')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(DISTINCT user_id) as users'))
            ->where('created_at', '>=', now()->subDays(12))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $activityDates = $activity->pluck('date')
            ->map(fn($d) => Carbon::parse($d)->format('M d'));
        $activityCounts = $activity->pluck('users');

        // Stats
        $totalClinicians = User::where('role', 'clinician')->count();
        $totalUsers = User::count();
        $totalCaregivers = User::where('role', 'caregiver')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalDocuments = \App\Models\Document::count(); // adjust your Document model

        // User distribution
        $clinicianPercentage = $totalUsers > 0 ? round(($totalClinicians / $totalUsers) * 100) : 0;
        $caregiverPercentage = $totalUsers > 0 ? round(($totalCaregivers / $totalUsers) * 100) : 0;

        // Recent users
        $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();

        return view('pages.dashboard', compact(
            'activityDates',
            'activityCounts',
            'totalClinicians',
            'totalUsers',
            'totalCaregivers',
            'totalAdmins',
            'recentUsers',
            'clinicianPercentage',
            'caregiverPercentage',
            'totalDocuments'
        ));
    }

    public function exportData()
    {
        $filename = 'user_data.csv'; // CSV filename
        $users = User::all(); // Fetch all users

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