<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Surgery;
use Illuminate\Support\Facades\Auth;

class DoctorSurgeryController extends Controller
{
    public function index()
    {
        $surgeries = Surgery::with(['patient', 'surgeryType'])
            ->where('tenant_id', Auth::user()->tenant_id)
            ->orderBy('surgery_date', 'desc')
            ->get();

        return view('doctor.surgeries.index', compact('surgeries'));
    }

    public function update(Request $request, Surgery $surgery)
    {
        abort_if($surgery->tenant_id !== Auth::user()->tenant_id, 403);

        $validatedData = $request->validate([
            'hospital_name' => 'required|string|max:255',
            'surgeon_name' => 'required|string|max:255',
            'disease_name' => 'required|string|max:255',
            'assistant_name' => 'nullable|string|max:255',
            'anesthesiologist_name' => 'nullable|string|max:255',
            'anesthesia_type' => 'required|string|in:تخدير عام,تخدير موضعي,تخدير قطني,أخرى',
            'cost' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'doctor_notes' => 'nullable|string',
        ]);

        $surgery->update($validatedData);

        return redirect()->back()->with('success', 'تم تحديث معلومات العملية بنجاح.');
    }
}
