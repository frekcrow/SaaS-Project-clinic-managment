<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClinicSetting;
use App\Models\Medication;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Support\Facades\Storage;

class PrescriptionController extends Controller
{
    public function index(Request $request)
    {
        $tenantId = $request->user()->tenant_id;

        $settings = ClinicSetting::firstOrCreate(
            ['tenant_id' => $tenantId],
            [
                'clinic_name' => $request->user()->clinic_name ?? 'العيادة',
                'doctor_name' => $request->user()->name ?? 'الدكتور'
            ]
        );

        $medications = Medication::where('tenant_id', $tenantId)->get();

        // Fetch appointments for today as a convenient patient list, or recently updated ones
        $appointments = Appointment::where('tenant_id', $tenantId)
            ->whereDate('appointment_date', today()->format('Y-m-d'))
            ->with('patient')
            ->get();

        return view('doctor.prescriptions.index', compact('settings', 'medications', 'appointments'));
    }

    public function updateSettings(Request $request)
    {
        $tenantId = $request->user()->tenant_id;
        $settings = ClinicSetting::firstOrCreate(['tenant_id' => $tenantId]);

        $validated = $request->validate([
            'clinic_name' => 'nullable|string|max:255',
            'doctor_name' => 'nullable|string|max:255',
            'logo_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'logo_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = [
            'clinic_name' => $validated['clinic_name'] ?? $settings->clinic_name,
            'doctor_name' => $validated['doctor_name'] ?? $settings->doctor_name,
        ];

        if ($request->hasFile('logo_1')) {
            if ($settings->logo_1_path) {
                Storage::disk('public')->delete($settings->logo_1_path);
            }
            $data['logo_1_path'] = $request->file('logo_1')->store('logos', 'public');
        }

        if ($request->hasFile('logo_2')) {
            if ($settings->logo_2_path) {
                Storage::disk('public')->delete($settings->logo_2_path);
            }
            $data['logo_2_path'] = $request->file('logo_2')->store('logos', 'public');
        }

        $settings->update($data);

        return redirect()->route('doctor.prescriptions.index')->with('success', 'تم حفظ إعدادات الوصفة بنجاح.');
    }
}
