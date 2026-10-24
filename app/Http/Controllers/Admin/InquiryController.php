<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Solution;
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
        $solutions = Solution::orderBy('title')->get(['slug', 'title']);

        return view('admin.inquiries.index', compact('inquiries', 'solutions'));
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

    public function export(Request $request)
    {
        $period = $request->get('period', 'all');

        $query = Inquiry::latest();

        if ($period === 'daily') {
            $query->whereDate('created_at', today());
            $filenamePeriod = 'daily_'.now()->format('Y-m-d');
        } elseif ($period === 'weekly') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            $filenamePeriod = 'weekly_'.now()->startOfWeek()->format('Y-m-d').'_to_'.now()->endOfWeek()->format('Y-m-d');
        } elseif ($period === 'monthly') {
            $query->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year);
            $filenamePeriod = 'monthly_'.now()->format('Y-m');
        } else {
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
            $filenamePeriod = 'all_'.now()->format('Y-m-d');
        }

        $inquiries = $query->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"inquiries_report_{$filenamePeriod}.csv\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($inquiries) {
            $file = fopen('php://output', 'w');

            // UTF-8 BOM for Excel UTF-8 support
            fwrite($file, "\xEF\xBB\xBF");

            fputcsv($file, [
                'Request ID',
                'Vertical / Capability',
                'Client Name',
                'Company Name',
                'Position / Designation',
                'Work Email',
                'Phone / WhatsApp',
                'Country',
                'Requirement Details',
                'Document Attached',
                'Status',
                'Submission Date & Time',
            ]);

            foreach ($inquiries as $inq) {
                fputcsv($file, [
                    $inq->request_id,
                    $inq->vertical_label,
                    $inq->name,
                    $inq->company ?: '-',
                    $inq->position ?: '-',
                    $inq->email,
                    $inq->phone ?: '-',
                    $inq->country ?: '-',
                    $inq->details,
                    ! empty($inq->doc_path) ? 'Yes' : 'No',
                    $inq->status_label,
                    $inq->created_at ? $inq->created_at->format('Y-m-d H:i:s') : '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
