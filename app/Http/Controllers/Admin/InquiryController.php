<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inquiry::latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('vertical')) {
            $query->where('vertical', $request->vertical);
        }
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($q2) use ($q) {
                $q2->where('request_id', 'like', "%{$q}%")
                    ->orWhere('name', 'like', "%{$q}%")
                    ->orWhere('company', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        $inquiries = $query->paginate(20)->withQueryString();

        return view('admin.inquiries.index', compact('inquiries'));
    }

    public function show(Request $request, Inquiry $inquiry)
    {
        if ($request->boolean('download') && ! empty($inquiry->doc_path)) {
            if (Storage::disk('local')->exists($inquiry->doc_path)) {
                return Storage::disk('local')->download($inquiry->doc_path);
            }

            return back()->with('error', 'The requested document file could not be found on the server.');
        }

        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function update(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,in_review,information_required,processing,completed,closed',
            'internal_notes' => 'nullable|string|max:5000',
        ]);

        $inquiry->update($validated);

        return back()->with('success', "Inquiry {$inquiry->request_id} updated successfully.");
    }
}
