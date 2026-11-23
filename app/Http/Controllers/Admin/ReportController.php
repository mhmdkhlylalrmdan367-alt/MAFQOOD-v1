<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Notifications\ReportStatusChanged;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::with(['user', 'reportable'])->latest();

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($reason = $request->input('reason')) {
            $query->where('reason', $reason);
        }

        $reports = $query->paginate(20)->withQueryString();

        return view('admin.reports.reports', compact('reports'));
    }

    public function show(Report $report)
    {
        $report->load(['user', 'reportable', 'reviewer']);
        return view('admin.reports.show', compact('report'));
    }

    public function update(Request $request, Report $report)
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,reviewed,accepted,rejected'],
            'admin_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $data['reviewed_by'] = auth()->id();
        $data['reviewed_at'] = now();

        $report->update($data);

        // إشعار صاحب البلاغ
        if ($report->user) {
            $report->user->notify(new ReportStatusChanged($report, $data['status']));
        }

        return redirect()->route('admin.reports.index')->with('success', 'تم تحديث البلاغ');
    }

    public function action(Request $request, Report $report)
    {
        $request->validate([
            'action' => ['required', 'in:hide_item,delete_item,dismiss'],
        ]);

        switch ($request->input('action')) {
            case 'hide_item':
                if ($report->reportable_type === \App\Models\Item::class) {
                    $report->reportable->update(['status' => 'hidden']);
                }
                $report->update([
                    'status' => 'accepted',
                    'reviewed_by' => auth()->id(),
                    'reviewed_at' => now(),
                ]);
                break;

            case 'delete_item':
                if ($report->reportable_type === \App\Models\Item::class) {
                    $report->reportable->delete();
                }
                $report->update([
                    'status' => 'accepted',
                    'reviewed_by' => auth()->id(),
                    'reviewed_at' => now(),
                ]);
                break;

            case 'dismiss':
                $report->update([
                    'status' => 'rejected',
                    'reviewed_by' => auth()->id(),
                    'reviewed_at' => now(),
                ]);
                break;
        }

        if ($report->user) {
            $report->user->notify(new ReportStatusChanged($report, $report->fresh()->status));
        }

        return redirect()->route('admin.reports.index')->with('success', 'تم تنفيذ الإجراء');
    }
}
