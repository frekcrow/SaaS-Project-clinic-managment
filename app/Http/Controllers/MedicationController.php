<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Medication;

class MedicationController extends Controller
{
    public function index()
    {
        $medications = Medication::orderBy('name')->get();
        return view('doctor.medications.index', compact('medications'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'indications' => 'nullable|string',
            'dosages' => 'nullable|array',
            'dosages.*' => 'nullable|string',
            'usage_times' => 'nullable|array',
            'usage_times.*' => 'nullable|string',
        ]);

        // Clean arrays
        $validated['dosages'] = array_values(array_filter($validated['dosages'] ?? []));
        $validated['usage_times'] = array_values(array_filter($validated['usage_times'] ?? []));

        Medication::create($validated);

        return redirect()->route('doctor.medications.index')->with('success', __('تم إضافة الدواء بنجاح.'));
    }

    public function update(Request $request, Medication $medication)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'indications' => 'nullable|string',
            'dosages' => 'nullable|array',
            'dosages.*' => 'nullable|string',
            'usage_times' => 'nullable|array',
            'usage_times.*' => 'nullable|string',
        ]);

        // Clean arrays
        $validated['dosages'] = array_values(array_filter($validated['dosages'] ?? []));
        $validated['usage_times'] = array_values(array_filter($validated['usage_times'] ?? []));

        $medication->update($validated);

        return redirect()->route('doctor.medications.index')->with('success', __('تم تحديث الدواء بنجاح.'));
    }

    public function destroy(Medication $medication)
    {
        $medication->delete();

        return redirect()->route('doctor.medications.index')->with('success', __('تم حذف الدواء بنجاح.'));
    }
}
