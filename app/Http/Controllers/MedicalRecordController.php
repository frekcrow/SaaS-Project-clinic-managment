<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function index(Patient $patient)
    {
        abort_if($patient->tenant_id !== auth()->user()->tenant_id, 403);
        $records = $patient->medicalRecords()->latest()->get();
        return view('medical_records.index', compact('patient', 'records'));
    }

    public function create(Patient $patient)
    {
        abort_if($patient->tenant_id !== auth()->user()->tenant_id, 403);
        return view('medical_records.create', compact('patient'));
    }

    public function store(Request $request, Patient $patient)
    {
        abort_if($patient->tenant_id !== auth()->user()->tenant_id, 403);
        $validated = $request->validate([
            'diagnosis' => 'required|string',
            'prescription' => 'nullable|string',
            'lab_tests_required' => 'nullable|string',
            'lab_results' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'xrays' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'diagnostic_images' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $attachments = [];
        if ($request->hasFile('lab_results')) {
            $attachments['lab_results'] = $request->file('lab_results')->store('attachments', 'public');
        }
        if ($request->hasFile('xrays')) {
            $attachments['xrays'] = $request->file('xrays')->store('attachments', 'public');
        }
        if ($request->hasFile('diagnostic_images')) {
            $attachments['diagnostic_images'] = $request->file('diagnostic_images')->store('attachments', 'public');
        }

        $medicalRecord = new MedicalRecord([
            'diagnosis' => $validated['diagnosis'],
            'prescription' => $validated['prescription'] ?? null,
            'lab_tests_required' => $validated['lab_tests_required'] ?? null,
            'attachments' => $attachments,
            'doctor_id' => auth()->id(),
            'tenant_id' => auth()->user()->tenant_id,
        ]);

        $patient->medicalRecords()->save($medicalRecord);

        return redirect()->route('medical_records.index', $patient)->with('success', 'تم إنشاء الملف التشخيصي بنجاح.');
    }

    public function show(MedicalRecord $medical_record)
    {
        abort_if($medical_record->tenant_id !== auth()->user()->tenant_id, 403);
        return view('medical_records.show', compact('medical_record'));
    }

    public function update(Request $request, MedicalRecord $medical_record)
    {
        abort_if($medical_record->tenant_id !== auth()->user()->tenant_id, 403);

        $validated = $request->validate([
            'diagnosis' => 'required|string',
            'prescription' => 'nullable|string',
            'lab_tests_required' => 'nullable|string',
        ]);

        $medical_record->update($validated);

        return redirect()->route('medical_records.show', $medical_record)->with('success', 'تم حفظ التغييرات بنجاح.');
    }

    public function exportPdf(MedicalRecord $medical_record)
    {
        abort_if($medical_record->tenant_id !== auth()->user()->tenant_id, 403);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('medical_records.pdf', compact('medical_record'));
        return $pdf->download('medical_record_' . $medical_record->id . '.pdf');
    }
}
