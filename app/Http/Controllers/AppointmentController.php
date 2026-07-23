<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::with(['doctor', 'patient'])
            ->where('tenant_id', Auth::user()->tenant_id)
            ->orderBy('appointment_datetime')
            ->get();

        return view('appointments.index', compact('appointments'));
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

        return view('appointments.create', compact('doctors'));
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
            'appointment_datetime' => 'required|date',
            'price' => 'nullable|numeric|min:0',
        ]);

        $validatedData['tenant_id'] = Auth::user()->tenant_id;

        Appointment::create($validatedData);

        return redirect()->route('appointments.index')->with('success', 'Appointment added successfully.');
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
            'appointment_datetime' => 'nullable|date',
            'price' => 'nullable|numeric|min:0',
            'status' => 'sometimes|required|in:pending,completed,cancelled',
        ]);

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
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $appointment->update(['status' => $validatedData['status']]);

        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    /**
     * Export all appointments as CSV.
     */
    public function exportCsv(Request $request)
    {
        $appointments = Appointment::with(['doctor', 'patient'])
            ->where('tenant_id', $request->user()->tenant_id)
            ->orderBy('appointment_datetime')
            ->get();

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=appointments.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'اسم المريض', 'رقم الهاتف', 'الطبيب', 'تاريخ ووقت الموعد', 'السعر', 'الحالة'];

        $callback = function () use ($appointments, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // Add BOM for Excel UTF-8 support
            fputcsv($file, $columns);

            foreach ($appointments as $appointment) {
                fputcsv($file, [
                    $appointment->id,
                    $appointment->patient->name ?? $appointment->patient_name,
                    $appointment->patient->phone ?? $appointment->phone ?? '-',
                    $appointment->doctor->name ?? '-',
                    $appointment->appointment_datetime->format('Y-m-d H:i'),
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
