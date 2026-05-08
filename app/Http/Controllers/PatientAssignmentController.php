<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PatientAssignmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'staff_id' => 'required|exists:users,id',
            'assignment_type' => 'required|in:primary,backup,specialist',
        ]);

        \App\Models\PatientStaffAssignment::updateOrCreate(
            ['patient_id' => $request->patient_id, 'staff_id' => $request->staff_id],
            ['assignment_type' => $request->assignment_type]
        );

        return back()->with('success', 'Staff assigned successfully.');
    }

    public function destroy($id)
    {
        $assignment = \App\Models\PatientStaffAssignment::findOrFail($id);
        $assignment->delete();

        return back()->with('success', 'Assignment revoked.');
    }
}
