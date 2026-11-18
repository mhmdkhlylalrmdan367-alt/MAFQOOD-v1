<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SiteReportRequest;
use App\Services\SiteReport;
use App\Support\XlsxExport;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SiteReportController extends Controller
{
    public function index(SiteReportRequest $request): View
    {
        $report = $this->report($request);

        return view('admin.site-reports', [
            'from' => $report->from->toDateString(),
            'to' => $report->to->toDateString(),
            'summary' => $report->summary(),
            'categories' => $report->categories(),
            'items' => $report->items()->with(['category', 'region'])->latest()->paginate(20)->withQueryString(),
        ]);
    }

    public function export(SiteReportRequest $request, XlsxExport $export): BinaryFileResponse
    {
        $report = $this->report($request);
        $file = $export->create($report->sheets($report->summary(), $report->categories()));
        $filename = 'luqya-report-'.$report->from->toDateString().'-'.$report->to->toDateString().'.xlsx';

        return response()->download($file, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'private, no-store',
        ])->deleteFileAfterSend(true);
    }

    private function report(SiteReportRequest $request): SiteReport
    {
        return new SiteReport(
            CarbonImmutable::createFromFormat('!Y-m-d', $request->validated('from')),
            CarbonImmutable::createFromFormat('!Y-m-d', $request->validated('to')),
        );
    }
}
