<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::all();
        $surgeryTypes = \App\Models\SurgeryType::where('tenant_id', Auth::user()->tenant_id)->get();
        return view('patients.index', compact('patients', 'surgeryTypes'));
    }

    /**
     * Search for patients by name.
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return response()->json([]);
        }

        $patients = Patient::where('name', 'like', '%' . $query . '%')
            ->where('tenant_id', $request->user()->tenant_id)
            ->select('id', 'name', 'phone')
            ->limit(10)
            ->get();

        return response()->json($patients);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctors = User::where('role', 'Doctor')
            ->where('tenant_id', Auth::user()->tenant_id)
            ->get();

        return view('patients.create', compact('doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'dob_day' => 'nullable|integer|min:1|max:31',
            'dob_month' => 'nullable|integer|min:1|max:12',
            'dob_year' => 'nullable|integer|min:1900|max:2100',
            'phone' => 'nullable|string|regex:/^[0-9]+$/|max:255',
            'doctor_id' => [
                'nullable',
                \Illuminate\Validation\Rule::exists('users', 'id')->where(function ($query) use ($request) {
                    return $query->where('tenant_id', $request->user()->tenant_id);
                }),
            ],
            'visit_reason' => 'nullable|string',
            'symptoms_onset' => 'nullable|string|max:255',
            'allergies' => 'nullable|string',
            'chronic_diseases' => 'nullable|string',
            'regular_medications' => 'nullable|string',
            'gender' => 'nullable|string',
            'smoking_status' => 'nullable|string',
            'blood_type' => 'nullable|string',
        ]);

        if ($request->filled(['dob_day', 'dob_month', 'dob_year'])) {
            $validatedData['dob'] = sprintf('%04d-%02d-%02d', $request->input('dob_year'), $request->input('dob_month'), $request->input('dob_day'));
        }
        unset($validatedData['dob_day'], $validatedData['dob_month'], $validatedData['dob_year']);

        $validatedData['tenant_id'] = Auth::user()->tenant_id;

        $patient = Patient::create($validatedData);

        if ($request->filled('visit_reason') || $request->filled('symptoms_onset')) {
            $defaultDoctorId = User::where('role', 'Doctor')
                ->where('tenant_id', Auth::user()->tenant_id)
                ->first()?->id ?? Auth::id();

            \App\Models\MedicalRecord::create([
                'tenant_id' => Auth::user()->tenant_id,
                'patient_id' => $patient->id,
                'doctor_id' => $defaultDoctorId,
                'diagnosis' => 'قيد الانتظار',
                'visit_reason' => $request->input('visit_reason'),
                'symptoms_onset' => $request->input('symptoms_onset'),
            ]);
        }

        return redirect()->route('patients.index')->with('success', __('Patient added successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $patient = Patient::with(['medicalRecords' => function ($query) {
            $query->orderBy('visit_date', 'desc');
        }])->findOrFail($id);

        abort_if($patient->tenant_id !== auth()->user()->tenant_id, 403);

        return view('patients.show', compact('patient'));
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
    public function update(Request $request, Patient $patient)
    {
        abort_if($patient->tenant_id !== auth()->user()->tenant_id, 403);

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'dob' => 'nullable|date',
            'phone' => 'nullable|string|regex:/^[0-9]+$/|max:255',
            'gender' => 'nullable|string',
            'smoking_status' => 'nullable|string',
            'blood_type' => 'nullable|string',
        ]);

        $patient->update($validatedData);

        return response()->json(['message' => 'Patient updated successfully', 'patient' => $patient]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Export all patients as CSV.
     */
    public function exportCsv(Request $request)
    {
        $patients = Patient::where('tenant_id', $request->user()->tenant_id)->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=patients.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Name', 'Phone', 'Date of Birth', 'Created At'];

        $callback = function () use ($patients, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($patients as $patient) {
                fputcsv($file, [
                    $patient->id,
                    $patient->name,
                    $patient->phone,
                    $patient->dob ? $patient->dob->format('Y-m-d') : '',
                    $patient->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Bulk delete patients.
     */
    public function bulkDelete(Request $request)
    {
        $validatedData = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:patients,id',
        ]);

        $deletedCount = Patient::whereIn('id', $validatedData['ids'])
            ->where('tenant_id', $request->user()->tenant_id)
            ->delete();

        return response()->json([
            'message' => "Successfully deleted $deletedCount patients.",
            'deleted' => $deletedCount
        ]);
    }
}
