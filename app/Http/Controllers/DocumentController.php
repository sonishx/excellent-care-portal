<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::where('user_id', Auth::id())->latest()->get();

        return view('pages.documents', compact('documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:25600',
        ]);

        $file = $request->file('document_file');
        $path = $file->store('documents', 'public');

        Document::create([
            'user_id' => Auth::id(),
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_type' => strtoupper($file->getClientOriginalExtension()),
            'file_size' => round($file->getSize() / 1024 / 1024, 2) . ' MB',
            'uploaded_by' => Auth::user()->name,
        ]);

        return redirect()->route('documents')->with('success', 'Document uploaded successfully.');
    }

    public function download($id)
    {
        $document = Document::where('user_id', Auth::id())->findOrFail($id);

        return Storage::disk('public')->download($document->file_path, $document->file_name);
    }

    public function destroy($id)
    {
        $document = Document::where('user_id', Auth::id())->findOrFail($id);

        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('documents')->with('success', 'Document deleted successfully.');
    }
}