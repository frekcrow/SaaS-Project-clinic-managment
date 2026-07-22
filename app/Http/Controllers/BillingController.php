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

        $query = Appointment::where('tenant_id', $tenantId)
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

        // Calculate total amount paid per patient (using patient_name since patient_id is not consistently available)
        $patientTotals = Appointment::selectRaw('patient_name, SUM(price) as total_paid')
            ->where('tenant_id', $tenantId)
            ->where('status', 'completed')
            ->groupBy('patient_name')
            ->pluck('total_paid', 'patient_name');

        // Attach totals to current appointments for the view
        foreach ($appointments as $appointment) {
            $appointment->total_paid = $patientTotals[$appointment->patient_name] ?? $appointment->price;
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
}
