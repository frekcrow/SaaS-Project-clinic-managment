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
        return view('patients.index', compact('patients'));
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
            'dob' => 'nullable|date',
            'phone' => 'nullable|string|max:255',
            'doctor_id' => 'nullable|exists:users,id',
            'reason_for_visit' => 'nullable|string',
            'symptoms_onset' => 'nullable|string|max:255',
            'allergies' => 'nullable|string',
            'chronic_diseases' => 'nullable|string',
            'regular_medications' => 'nullable|string',
        ]);

        $validatedData['tenant_id'] = Auth::user()->tenant_id;

        Patient::create($validatedData);

        return redirect()->route('patients.index')->with('success', 'Patient added successfully.');
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
