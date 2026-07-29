<?php

namespace App\Http\Controllers;

use App\Models\Surgery;
use App\Models\SurgeryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurgeryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $surgeries = Surgery::with(['patient', 'surgeryType'])
            ->where('tenant_id', Auth::user()->tenant_id)
            ->orderBy('surgery_date', 'desc')
            ->get();

        $surgeryTypes = SurgeryType::where('tenant_id', Auth::user()->tenant_id)->get();

        return view('surgeries.index', compact('surgeries', 'surgeryTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => [
                'required',
                \Illuminate\Validation\Rule::exists('patients', 'id')->where(function ($query) {
                    return $query->where('tenant_id', Auth::user()->tenant_id);
                }),
            ],
            'surgery_type_id' => [
                'required',
                \Illuminate\Validation\Rule::exists('surgery_types', 'id')->where(function ($query) {
                    return $query->where('tenant_id', Auth::user()->tenant_id);
                }),
            ],
            'surgery_date' => 'required|date',
        ]);

        $validatedData['tenant_id'] = Auth::user()->tenant_id;
        $validatedData['status'] = 'pending';

        Surgery::create($validatedData);

        return redirect()->back()->with('success', 'Surgery added successfully.');
    }

    /**
     * Update the status of the specified resource.
     */
    public function updateStatus(Request $request, Surgery $surgery)
    {
        abort_if($surgery->tenant_id !== Auth::user()->tenant_id, 403);

        $validatedData = $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $surgery->update(['status' => $validatedData['status']]);

        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    /**
     * Export all surgeries as CSV.
     */
    public function exportCsv(Request $request)
    {
        $surgeries = Surgery::with(['patient', 'surgeryType'])
            ->where('tenant_id', $request->user()->tenant_id)
            ->orderBy('surgery_date', 'desc')
            ->get();

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=surgeries.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'اسم المريض', 'نوع العملية', 'تاريخ العملية', 'الحالة'];

        $callback = function () use ($surgeries, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // Add BOM for Excel UTF-8 support
            fputcsv($file, $columns);

            foreach ($surgeries as $surgery) {
                fputcsv($file, [
                    $surgery->id,
                    $surgery->patient->name ?? '-',
                    $surgery->surgeryType->name ?? '-',
                    $surgery->surgery_date->format('Y-m-d'),
                    $surgery->status
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Bulk delete surgeries.
     */
    public function bulkDelete(Request $request)
    {
        $validatedData = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:surgeries,id',
        ]);

        $deletedCount = Surgery::whereIn('id', $validatedData['ids'])
            ->where('tenant_id', $request->user()->tenant_id)
            ->delete();

        return response()->json([
            'message' => "Successfully deleted $deletedCount surgeries.",
            'deleted' => $deletedCount
        ]);
    }
}
