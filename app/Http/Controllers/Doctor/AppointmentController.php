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
        $remainingPatients = Appointment::where('tenant_id', $tenantId)
            ->where('doctor_id', $doctorId)
            ->whereDate('appointment_date', now()->format('Y-m-d'))
            ->where('status', 'arrived')
            ->count();

        return view('doctor.appointments.index', compact(
            'appointments',
            'viewMode',
            'filterDate',
            'hourlySummary',
            'remainingPatients'
        ));
    }

    /**
     * Update the status of the specified appointment.
     */
    public function updateStatus(Request $request, Appointment $appointment)
    {
        abort_if($appointment->tenant_id !== Auth::user()->tenant_id, 403);

        $validatedData = $request->validate([
            'status' => 'required|in:pending,completed,cancelled,in_progress,arrived',
        ]);

        $oldStatus = $appointment->status;
        $newStatus = $validatedData['status'];

        if ($newStatus === 'in_progress' && $oldStatus !== 'in_progress') {
            $appointment->update([
                'status' => 'in_progress',
                'session_started_at' => now(),
            ]);

            // Notify secretary about session start
            $secretaries = \App\Models\User::where('tenant_id', Auth::user()->tenant_id)
                ->where('role', '!=', 'Doctor')
                ->get();
            foreach ($secretaries as $secretary) {
                $secretary->notify(new \App\Notifications\GeneralNotification("بدأت الجلسة للمراجع رقم {$appointment->queue_number}", 'info', 'play'));
            }

        } elseif ($newStatus === 'completed' && $oldStatus === 'in_progress') {
            $appointment->update(['status' => $newStatus]);

            // Notify secretary about session end
            $secretaries = \App\Models\User::where('tenant_id', Auth::user()->tenant_id)
                ->where('role', '!=', 'Doctor')
                ->get();
            foreach ($secretaries as $secretary) {
                $secretary->notify(new \App\Notifications\GeneralNotification("انتهت الجلسة للمراجع رقم {$appointment->queue_number}", 'success', 'check-circle'));
            }
        } else {
            $appointment->update(['status' => $newStatus]);
        }

        if ($request->wantsJson()) {
            if ($newStatus === 'completed') {
                return response()->json([
                    'success' => true,
                    'redirect_url' => route('doctor.patients.show', $appointment->patient_id)
                ]);
            }
            return response()->json(['success' => true]);
        }

        if ($newStatus === 'completed') {
            if ($appointment->patient_id) {
                return redirect()->route('doctor.patients.show', $appointment->patient_id)->with('success', __('Status updated successfully.'));
            }
            return redirect()->back()->with('success', __('Status updated successfully.'));
        }

        return redirect()->back()->with('success', __('Status updated successfully.'));
    }
}
