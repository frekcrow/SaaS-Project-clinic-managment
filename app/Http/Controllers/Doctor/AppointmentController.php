<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $tenantId = Auth::user()->tenant_id;
        $doctorId = Auth::id();

        $viewMode = $request->query('view_mode', 'default');
        $filterDate = $request->query('date', now()->format('Y-m-d'));

        $query = Appointment::with(['patient'])
            ->where('tenant_id', $tenantId)
            ->where('doctor_id', $doctorId)
            ->whereNotIn('status', ['in_progress', 'completed', 'cancelled']); // Queue sync logic

        if ($viewMode === 'default') {
            $query->whereDate('appointment_date', '>=', now()->format('Y-m-d'));
        } else {
            $query->whereDate('appointment_date', $filterDate);
        }

        $appointments = $query->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        // Calculate Hourly Summary for today
        $todayAppointments = Appointment::where('tenant_id', $tenantId)
            ->where('doctor_id', $doctorId)
            ->whereDate('appointment_date', now()->format('Y-m-d'))
            ->whereNotIn('status', ['in_progress', 'completed', 'cancelled'])
            ->get();

        $hourlySummary = $todayAppointments->groupBy(function($item) {
            return Carbon::parse($item->appointment_time)->format('H:00');
        })->map(function($group) {
            return $group->count();
        })->sortKeys();

        // Calculate remaining patients
        $remainingPatients = $todayAppointments->count();

        return view('doctor.appointments.index', compact(
            'appointments',
            'viewMode',
            'filterDate',
            'hourlySummary',
            'remainingPatients'
        ));
    }
}
