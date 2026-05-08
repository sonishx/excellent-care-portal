<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    // Ensure only Caregivers can access patient-related actions
    // Middleware is now handled in web.php routes

    public function index()
    {
        $user = Auth::user();
        
        if (strtolower($user->role) === 'admin') {
            $patients = Patient::with('assignedStaff')->latest()->get();
            $staffMembers = \App\Models\User::whereIn('role', ['clinician', 'caregiver'])->get();
        } else {
            // Staff only see assigned patients
            $patients = $user->assignedPatients()->with('assignedStaff')->latest()->get();
            $staffMembers = collect();
        }

        $totalPatients = strtolower($user->role) === 'admin' ? Patient::count() : $patients->count();
        $activePatients = strtolower($user->role) === 'admin' ? Patient::where('status', 'Active')->count() : $patients->where('status', 'Active')->count();
        $pendingPatients = strtolower($user->role) === 'admin' ? Patient::where('status', 'Pending Review')->count() : $patients->where('status', 'Pending Review')->count();
        $inactivePatients = strtolower($user->role) === 'admin' ? Patient::where('status', 'Inactive')->count() : $patients->where('status', 'Inactive')->count();

        return view('pages.patients', compact(
            'patients',
            'totalPatients',
            'activePatients',
            'pendingPatients',
            'inactivePatients',
            'staffMembers'
        ));
    }

    public function create()
    {
        // Display create patient form
        return view('pages.create-patient');
    }

    public function store(Request $request)
    {
        // Validate patient data
        $request->validate([
            'patient_code' => 'required|string|max:50|unique:patients,patient_code',
            'full_name' => 'required|string|max:255',
            'assigned_staff' => 'nullable|string|max:255',
            'care_plan' => 'nullable|string|max:255',
            'last_update' => 'nullable|date',
            'status' => 'required|string|in:Active,Inactive,Pending Review', // Added specific status validation
        ]);

        // Store new patient record
        Patient::create([
            'patient_code' => $request->patient_code,
            'full_name' => $request->full_name,
            'assigned_staff' => $request->assigned_staff,
            'care_plan' => $request->care_plan,
            'last_update' => $request->last_update,
            'status' => $request->status,
        ]);

        // Redirect to patient list with success message
        return redirect()->route('patients')->with('success', 'Patient added successfully.');
    }

    // Add edit and update functionality if needed
    public function edit($id)
    {
        // Find the patient by ID
        $patient = Patient::findOrFail($id);

        // Return edit form with patient data
        return view('pages.edit-patient', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        // Validate patient data
        $request->validate([
            'patient_code' => 'required|string|max:50|unique:patients,patient_code,' . $id,
            'full_name' => 'required|string|max:255',
            'assigned_staff' => 'nullable|string|max:255',
            'care_plan' => 'nullable|string|max:255',
            'last_update' => 'nullable|date',
            'status' => 'required|string|in:Active,Inactive,Pending Review',
        ]);

        // Find and update the patient
        $patient = Patient::findOrFail($id);
        $patient->update([
            'patient_code' => $request->patient_code,
            'full_name' => $request->full_name,
            'assigned_staff' => $request->assigned_staff,
            'care_plan' => $request->care_plan,
            'last_update' => $request->last_update,
            'status' => $request->status,
        ]);

        // Redirect to patients page with success message
        return redirect()->route('patients')->with('success', 'Patient updated successfully.');
    }

    // Add destroy function if needed for deletion
    public function destroy($id)
    {
        // Find the patient by ID
        $patient = Patient::findOrFail($id);

        // Delete the patient record
        $patient->delete();

        // Redirect to patients page with success message
        return redirect()->route('patients')->with('success', 'Patient deleted successfully.');
    }
}