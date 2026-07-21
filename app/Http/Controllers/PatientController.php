<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::with('doctor')->latest()->get();
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        $doctors = User::where('role', 'Doctor')->get();
        return view('patients.create', compact('doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'allergies' => 'nullable|string',
            'phone' => 'nullable|string|max:255',
            'chronic_diseases' => 'nullable|string',
            'regular_medications' => 'nullable|string',
            'doctor_id' => 'required|exists:users,id',
            'reason_for_visit' => 'nullable|string',
            'onset_of_symptoms' => 'nullable|string',
        ]);

        $validated['tenant_id'] = auth()->user()->tenant_id;

        Patient::create($validated);

        return redirect()->route('patients.index')->with('success', 'تم إضافة المريض بنجاح.');
    }

    public function export()
    {
        $patients = Patient::with('doctor')->get();

        $filename = "patients.csv";
        $handle = fopen('php://output', 'w');

        // Output BOM to ensure Arabic characters are displayed correctly in Excel
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

        fputcsv($handle, ['الاسم', 'تاريخ الميلاد', 'رقم الهاتف', 'الطبيب', 'سبب الزيارة', 'تاريخ الزيارة']);

        foreach ($patients as $patient) {
            fputcsv($handle, [
                $patient->name,
                $patient->dob,
                $patient->phone,
                $patient->doctor ? $patient->doctor->name : '',
                $patient->reason_for_visit,
                $patient->created_at->format('Y-m-d')
            ]);
        }

        fclose($handle);

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->stream(function() use ($handle) {}, 200, $headers);
    }
}
