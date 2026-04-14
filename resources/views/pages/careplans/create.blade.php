@extends('layouts.app')

@section('title', 'Add Care Note for ' . $patient->full_name)

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Add Care Note for {{ $patient->full_name }}</h2>

    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-3 mb-4 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('careplans.store', ['patientId' => $patient->id]) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="note" class="block font-semibold mb-1">Care Note</label>
            <textarea name="note" id="note" rows="5" class="w-full border rounded p-2">{{ old('note') }}</textarea>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Note</button>
        <a href="{{ route('careplans.index', ['patientId' => $patient->id]) }}" class="ml-2 text-gray-600 hover:underline">Cancel</a>
    </form>
</div>
@endsection