<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\SessionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pendingAppointments = Appointment::where('tenant_id', Auth::user()->tenant_id)
            ->where('status', 'pending')
            ->get();

        foreach ($pendingAppointments as $appt) {
            if ($appt->appointment_date && $appt->appointment_time) {
                $dateTimeString = $appt->appointment_date->format('Y-m-d') . ' ' . $appt->appointment_time;
                if (\Carbon\Carbon::parse($dateTimeString, 'Asia/Baghdad')->isPast()) {
                    $appt->update(['status' => 'cancelled']);
                }
            }
        }

        $appointments = Appointment::with(['doctor', 'patient', 'sessionType'])
            ->where('tenant_id', Auth::user()->tenant_id)
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        $sessionTypes = SessionType::where('tenant_id', Auth::user()->tenant_id)->get();

        return view('appointments.index', compact('appointments', 'sessionTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch all users with the 'Doctor' role, scoped to current logged-in user's tenant_id
        $doctors = User::where('tenant_id', Auth::user()->tenant_id)
                       ->where('role', 'Doctor')
                       ->get();

        $sessionTypes = SessionType::where('tenant_id', Auth::user()->tenant_id)->get();

        return view('appointments.create', compact('doctors', 'sessionTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => [
                'nullable',
                \Illuminate\Validation\Rule::exists('patients', 'id')->where(function ($query) {
                    return $query->where('tenant_id', Auth::user()->tenant_id);
                }),
            ],
            'patient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'doctor_id' => [
                'required',
                \Illuminate\Validation\Rule::exists('users', 'id')->where(function ($query) {
                    return $query->where('tenant_id', Auth::user()->tenant_id)
                                 ->where('role', 'Doctor');
                }),
            ],
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'price' => 'nullable|numeric|min:0',
            'is_session' => 'boolean',
            'session_type_id' => [
                'nullable',
                \Illuminate\Validation\Rule::exists('session_types', 'id')->where(function ($query) {
                    return $query->where('tenant_id', Auth::user()->tenant_id);
                }),
            ],
        ]);

        $validatedData['tenant_id'] = Auth::user()->tenant_id;
        $validatedData['is_session'] = $request->boolean('is_session');

        $maxQueue = Appointment::where('tenant_id', Auth::user()->tenant_id)
            ->where('appointment_date', $validatedData['appointment_date'])
            ->max('queue_number');

        $validatedData['queue_number'] = $maxQueue ? $maxQueue + 1 : 1;
        $validatedData['created_by'] = Auth::id();

        Appointment::create($validatedData);

        return redirect()->route('appointments.index')->with('success', __('Appointment added successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        abort_if($appointment->tenant_id !== auth()->user()->tenant_id, 403);

        $validatedData = $request->validate([
            'appointment_date' => 'nullable|date',
            'appointment_time' => 'nullable|date_format:H:i',
            'price' => 'nullable|numeric|min:0',
            'status' => 'sometimes|required|in:pending,completed,cancelled,in_progress',
            'is_session' => 'boolean',
            'session_type_id' => [
                'nullable',
                \Illuminate\Validation\Rule::exists('session_types', 'id')->where(function ($query) {
                    return $query->where('tenant_id', Auth::user()->tenant_id);
                }),
            ],
        ]);

        if ($request->has('is_session')) {
            $validatedData['is_session'] = $request->boolean('is_session');
        }

        $appointment->update($validatedData);

        return response()->json(['message' => 'Appointment updated successfully', 'appointment' => $appointment]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Update the status of the specified resource.
     */
    public function updateStatus(Request $request, Appointment $appointment)
    {
        abort_if($appointment->tenant_id !== Auth::user()->tenant_id, 403);

        $validatedData = $request->validate([
            'status' => 'required|in:pending,completed,cancelled,in_progress',
        ]);

        $oldStatus = $appointment->status;
        $newStatus = $validatedData['status'];

        if ($newStatus === 'in_progress' && $oldStatus !== 'in_progress') {
            $appointment->update([
                'status' => 'in_progress',
                'session_started_at' => now(),
            ]);

            // Notify secretary about session start
            $secretaries = User::where('tenant_id', Auth::user()->tenant_id)
                ->where('role', '!=', 'Doctor')
                ->get();
            foreach ($secretaries as $secretary) {
                $secretary->notify(new \App\Notifications\GeneralNotification("بدأت الجلسة للمراجع رقم {$appointment->queue_number}", 'info', 'play'));
            }

        } elseif ($newStatus === 'completed' && $oldStatus === 'in_progress') {
            $appointment->update(['status' => $newStatus]);

            // Notify secretary about session end
            $secretaries = User::where('tenant_id', Auth::user()->tenant_id)
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
                    'redirect_url' => route('patients.create', [
                        'name' => $appointment->patient->name ?? $appointment->patient_name,
                        'phone' => $appointment->patient->phone ?? $appointment->phone
                    ])
                ]);
            }
            return response()->json(['success' => true]);
        }

        if ($newStatus === 'completed') {
            return redirect()->route('patients.create', [
                'name' => $appointment->patient->name ?? $appointment->patient_name,
                'phone' => $appointment->patient->phone ?? $appointment->phone
            ])->with('success', __('Status updated successfully.'));
        }

        return redirect()->back()->with('success', __('Status updated successfully.'));
    }

    /**
     * Export all appointments as CSV.
     */
    public function currentQueue(Request $request)
    {
        $tenantId = Auth::user()->tenant_id;
        $today = today()->format('Y-m-d');

        $activeSession = Appointment::where('tenant_id', $tenantId)
            ->where('appointment_date', $today)
            ->where('status', 'in_progress')
            ->first();

        $nextSession = Appointment::where('tenant_id', $tenantId)
            ->where('appointment_date', $today)
            ->where('status', 'pending')
            ->orderBy('queue_number')
            ->first();

        return response()->json([
            'status' => $activeSession ? 'active' : 'waiting',
            'active_number' => $activeSession ? $activeSession->queue_number : null,
            'next_number' => $nextSession ? $nextSession->queue_number : null,
        ]);
    }

    /**
     * Export all appointments as CSV.
     */
    public function exportCsv(Request $request)
    {
        $appointments = Appointment::with(['doctor', 'patient'])
            ->where('tenant_id', $request->user()->tenant_id)
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=appointments.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', __('اسم المريض'), __('رقم الهاتف'), __('الطبيب'), __('تاريخ ووقت الموعد'), __('السعر'), __('الحالة')];

        $callback = function () use ($appointments, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // Add BOM for Excel UTF-8 support
            fputcsv($file, $columns);

            foreach ($appointments as $appointment) {
                $timeString = substr($appointment->appointment_time, 0, 5);
                fputcsv($file, [
                    $appointment->id,
                    $appointment->patient->name ?? $appointment->patient_name,
                    $appointment->patient->phone ?? $appointment->phone ?? '-',
                    $appointment->doctor->name ?? '-',
                    $appointment->appointment_date->format('Y-m-d') . ' ' . $timeString,
                    $appointment->price,
                    $appointment->status
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Bulk delete appointments.
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
            'message' => "Successfully deleted $deletedCount appointments.",
            'deleted' => $deletedCount
        ]);
    }
}
