<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\View\View;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $tenantId = $request->user()->tenant_id;

        $query = Appointment::with('patient')
            ->where('tenant_id', $tenantId)
            ->where('status', 'completed');

        // Filtering
        if ($request->has('filter')) {
            $filter = $request->get('filter');
            $now = Carbon::now();

            switch ($filter) {
                case 'today':
                    $query->whereDate('appointment_datetime', $now->toDateString());
                    break;
                case 'week':
                    $query->whereBetween('appointment_datetime', [
                        $now->startOfWeek()->toDateTimeString(),
                        $now->endOfWeek()->toDateTimeString()
                    ]);
                    break;
                case 'month':
                    $query->whereMonth('appointment_datetime', $now->month)
                          ->whereYear('appointment_datetime', $now->year);
                    break;
                case 'year':
                    $query->whereYear('appointment_datetime', $now->year);
                    break;
            }
        }

        $appointments = $query->orderBy('appointment_datetime', 'desc')->get();

        // Calculate total amount paid per patient (only for those with patient_id)
        $patientTotals = Appointment::selectRaw('patient_id, SUM(price) as total_paid')
            ->where('tenant_id', $tenantId)
            ->where('status', 'completed')
            ->whereNotNull('patient_id')
            ->groupBy('patient_id')
            ->pluck('total_paid', 'patient_id');

        // Attach totals to current appointments for the view
        foreach ($appointments as $appointment) {
            if ($appointment->patient_id) {
                $appointment->total_paid = $patientTotals[$appointment->patient_id] ?? $appointment->price;
            } else {
                $appointment->total_paid = $appointment->price; // Default to single appointment price if no patient_id
            }
        }

        // Get clinic name and doctor name
        $clinicName = $request->user()->tenant ? $request->user()->tenant->name : $request->user()->name;
        $doctorName = $request->user()->name;

        return view('billing.index', [
            'appointments' => $appointments,
            'clinicName' => $clinicName,
            'doctorName' => $doctorName,
        ]);
    }

    /**
     * Export all billing records as CSV.
     */
    public function exportCsv(Request $request)
    {
        $tenantId = $request->user()->tenant_id;
        $appointments = Appointment::with('patient')
            ->where('tenant_id', $tenantId)
            ->where('status', 'completed')
            ->orderBy('appointment_datetime', 'desc')
            ->get();

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=billing.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'اسم المريض', 'المبلغ المدفوع', 'رقم الهاتف', 'التاريخ', 'الوقت'];

        $callback = function () use ($appointments, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // Add BOM for Excel UTF-8 support
            fputcsv($file, $columns);

            foreach ($appointments as $appointment) {
                fputcsv($file, [
                    $appointment->id,
                    $appointment->patient->name ?? $appointment->patient_name,
                    $appointment->price,
                    $appointment->patient->phone ?? $appointment->phone ?? '-',
                    $appointment->appointment_datetime->format('Y-m-d'),
                    $appointment->appointment_datetime->format('H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Bulk delete billing records (appointments).
     */
    public function bulkDelete(Request $request)
    {
        $validatedData = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:appointments,id',
        ]);

        $deletedCount = Appointment::whereIn('id', $validatedData['ids'])
            ->where('tenant_id', $request->user()->tenant_id)
            ->delete();

        return response()->json([
            'message' => "Successfully deleted $deletedCount billing records.",
            'deleted' => $deletedCount
        ]);
    }
}
