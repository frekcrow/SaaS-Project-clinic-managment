<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\PatientImage;
use App\Models\MedicalRecord;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DoctorPatientController extends Controller
{
    public function index()
    {
        // Must be a doctor to access this (enforced by role check ideally, but handled mostly by UI routing right now)
        // Ensure tenant isolation
        $patients = Patient::withTrashed()->where('tenant_id', Auth::user()->tenant_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('doctor.patients.index', compact('patients'));
    }

    public function show(Patient $patient)
    {
        abort_if($patient->tenant_id !== Auth::user()->tenant_id, 403);

        $patient->load(['medicalRecords' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }, 'patientImages' => function($query) {
            $query->orderBy('created_at', 'desc');
        }]);

        return view('doctor.patients.show', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        abort_if($patient->tenant_id !== Auth::user()->tenant_id, 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string|in:male,female',
            'blood_type' => 'nullable|string',
            'allergies' => 'nullable|string',
            'chronic_diseases' => 'nullable|string',
            'regular_medications' => 'nullable|string',
            'reason_for_visit' => 'nullable|string',
            'symptoms_onset' => 'nullable|string',
        ]);

        $patient->update($validated);

        return back()->with('success', __('تم تحديث معلومات المريض بنجاح.'));
    }

    public function storeRecord(Request $request, Patient $patient)
    {
        abort_if($patient->tenant_id !== Auth::user()->tenant_id, 403);

        $validated = $request->validate([
            'diagnosis' => 'required|string',
            'prescription' => 'nullable|string',
            'lab_tests' => 'nullable|string',
        ]);

        // If there's an existing 'قيد الانتظار' record, we update it. Otherwise create new.
        $record = $patient->medicalRecords()->where('diagnosis', 'قيد الانتظار')->first();

        if ($record) {
            $record->update([
                'diagnosis' => $validated['diagnosis'],
                'prescription' => $validated['prescription'],
                'lab_tests' => $validated['lab_tests'],
                'doctor_id' => Auth::id(),
            ]);
        } else {
            $patient->medicalRecords()->create([
                'tenant_id' => Auth::user()->tenant_id,
                'doctor_id' => Auth::id(),
                'diagnosis' => $validated['diagnosis'],
                'prescription' => $validated['prescription'],
                'lab_tests' => $validated['lab_tests'],
            ]);
        }

        return back()->with('success', __('تم حفظ السجل الطبي بنجاح.'));
    }

    public function uploadImage(Request $request, Patient $patient)
    {
        abort_if($patient->tenant_id !== Auth::user()->tenant_id, 403);

        $request->validate([
            'album_type' => 'required|in:xray,prescription,diagnostic',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB max
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('patient_images/' . $patient->id, 'public');

            $patient->patientImages()->create([
                'album_type' => $request->album_type,
                'image_path' => $path,
            ]);

            return back()->with('success', __('تم رفع الصورة بنجاح.'));
        }

        return back()->with('error', __('فشل في رفع الصورة.'));
    }

    public function deleteImage(Patient $patient, PatientImage $image)
    {
        abort_if($patient->tenant_id !== Auth::user()->tenant_id, 403);
        abort_if($image->patient_id !== $patient->id, 404);

        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return back()->with('success', __('تم حذف الصورة بنجاح.'));
    }
}
