<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::latest()->get();

        $totalPatients = Patient::count();
        $activePatients = Patient::where('status', 'Active')->count();
        $pendingPatients = Patient::where('status', 'Pending Review')->count();
        $inactivePatients = Patient::where('status', 'Inactive')->count();

        return view('pages.patients', compact(
            'patients',
            'totalPatients',
            'activePatients',
            'pendingPatients',
            'inactivePatients'
        ));
    }

    public function create()
    {
        return view('pages.create-patient');
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_code' => 'required|string|max:50|unique:patients,patient_code',
            'full_name' => 'required|string|max:255',
            'assigned_staff' => 'nullable|string|max:255',
            'care_plan' => 'nullable|string|max:255',
            'last_update' => 'nullable|date',
            'status' => 'required|string',
        ]);

        Patient::create([
            'patient_code' => $request->patient_code,
            'full_name' => $request->full_name,
            'assigned_staff' => $request->assigned_staff,
            'care_plan' => $request->care_plan,
            'last_update' => $request->last_update,
            'status' => $request->status,
        ]);

        return redirect()->route('patients')->with('success', 'Patient added successfully.');
    }
}