<?php

namespace App\Http\Controllers;

use App\Models\CareNote;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CareNoteController extends Controller
{
    // Show all care notes for a patient
    public function index($patientId)
    {
        $patient = Patient::findOrFail($patientId);
        $careNotes = $patient->careNotes()->with('user')->latest()->get();

        return view('pages.careplans.index', compact('patient', 'careNotes'));
    }

    // Show form to create a new care note
    public function create($patientId)
    {
        $patient = Patient::findOrFail($patientId);
        return view('pages.careplans.create', compact('patient'));
    }

    // Store new care note
    public function store(Request $request, $patientId)
    {
        $request->validate([
            'note' => 'required|string|max:1000',
        ]);

        CareNote::create([
            'patient_id' => $patientId,
            'user_id' => Auth::id(),
            'note' => $request->note,
        ]);

        return redirect()->route('careplans.index', $patientId)
                         ->with('success', 'Care note added successfully.');
    }

    public function selectPatient()
{
    $patients = \App\Models\Patient::all();
    return view('pages.careplans.select-patient', compact('patients'));
}
    public function destroy($id)
    {
        $note = CareNote::findOrFail($id);

        // Only the creator or admin can delete
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $note->delete();

        return back()->with('success', 'Care note deleted successfully.');
    }
}