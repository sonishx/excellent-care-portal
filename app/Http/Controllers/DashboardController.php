<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- required for DB queries
use Carbon\Carbon; // <-- required for Carbon date handling
use App\Models\User;
use App\Models\ChatMessage; // if used for messages
use App\Models\Document; // if used for documents
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private function patientIndex()
    {
        $user = Auth::user();
        
        // Robust direct link via user_id
        $patientRecord = \App\Models\Patient::where('user_id', $user->id)->first();
        
        // Fallback for existing data without user_id
        if (!$patientRecord) {
            $patientRecord = \App\Models\Patient::where('full_name', 'LIKE', '%' . $user->name . '%')->first();
        }
        
        $careNotes = $patientRecord ? $patientRecord->careNotes()->latest()->take(5)->get() : collect();
        $assignedStaff = $patientRecord ? $patientRecord->assignedStaff : collect();
        $recentMessages = \App\Models\Message::where('receiver_id', $user->id)->latest()->take(3)->get();

        return view('pages.patient.dashboard', compact('user', 'patientRecord', 'careNotes', 'assignedStaff', 'recentMessages'));
    }

    public function index()
    {
        $user = Auth::user();

        // Redirect Patients to their specific dashboard
        if ($user->role === 'patient') {
            return $this->patientIndex();
        }

        $activity = DB::table('user_activity')
            ->select(DB::raw('DATE(created_at) as date'), 'role', DB::raw('COUNT(DISTINCT user_id) as users'))
            ->where('created_at', '>=', now()->subDays(12))
            ->groupBy('date', 'role')
            ->orderBy('date', 'asc')
            ->get();

        $activityDates = $activity->pluck('date')->unique()
            ->map(fn($d) => Carbon::parse($d)->format('M d'))->values();
        
        $clinicianActivity = $activityDates->map(function($date) use ($activity) {
            $record = $activity->where('role', 'clinician')->filter(fn($item) => Carbon::parse($item->date)->format('M d') === $date)->first();
            return $record ? $record->users : 0;
        });

        $caregiverActivity = $activityDates->map(function($date) use ($activity) {
            $record = $activity->where('role', 'caregiver')->filter(fn($item) => Carbon::parse($item->date)->format('M d') === $date)->first();
            return $record ? $record->users : 0;
        });

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
            'clinicianActivity',
            'caregiverActivity',
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