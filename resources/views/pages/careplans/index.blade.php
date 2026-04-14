@extends('layouts.app')

@section('title', 'Care Plans for ' . $patient->full_name)

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Care Plans for {{ $patient->full_name }}</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('careplans.create', ['patientId' => $patient->id]) }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
        Add New Care Note
    </a>

    @if($careNotes->isEmpty())
        <p class="text-gray-500">No care notes available yet.</p>
    @else
        <div class="space-y-4">
            @foreach($careNotes as $note)
                <div class="border p-4 rounded shadow">
                    <p>{{ $note->note }}</p>
                    <small class="text-gray-500">
                        Added by {{ $note->user->name ?? 'Unknown' }} on {{ $note->created_at->format('d M Y, H:i') }}
                    </small>
                    @if($note->user_id === auth()->id())
                        <form action="{{ route('careplans.destroy', ['patientId' => $patient->id, 'id' => $note->id]) }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection