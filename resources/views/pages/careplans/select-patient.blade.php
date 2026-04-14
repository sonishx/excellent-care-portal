@extends('layouts.app')

@section('title', 'Select Patient - Care Plans')

@section('content')

<div class="patients-page">
    <div class="patients-content">
        <div class="breadcrumb">Home &nbsp; &gt; &nbsp; Care Plans</div>

        <div class="page-title-row">
            <div>
                <div class="page-title">Select a Patient</div>
                <div class="page-subtitle">
                    Choose a patient to view or add care plans.
                </div>
            </div>
        </div>

        <div class="panel">
            <table class="patient-table">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>NDIS ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                        <tr>
                            <td>{{ $patient->full_name }}</td>
                            <td>{{ $patient->patient_code }}</td>
                            <td>
                                <a href="{{ route('careplans.index', ['patientId' => $patient->id]) }}" class="action-link">View Care Plans</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No patients found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection