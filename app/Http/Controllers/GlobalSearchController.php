<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class GlobalSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');
        if (!$query) {
            return response()->json([]);
        }

        $results = [];

        // Search Patients for Records
        $patients = Patient::where('name', 'like', '%' . $query . '%')
            ->where('tenant_id', Auth::user()->tenant_id)
            ->limit(5)
            ->get();

        foreach ($patients as $patient) {
            $results[] = [
                'type' => 'patient_record',
                'title' => $patient->name,
                'subtitle' => 'سجل المريض',
                'url' => route('patients.show', $patient->id),
                'icon' => 'user'
            ];

            $results[] = [
                'type' => 'patient_appointment',
                'title' => $patient->name,
                'subtitle' => 'المواعيد',
                'url' => route('appointments.index', ['search' => $patient->name]),
                'icon' => 'calendar'
            ];
        }

        // Search Sections
        $sections = [
            ['name' => 'الرئيسية', 'route' => 'dashboard', 'icon' => 'folder'],
            ['name' => 'العمليات', 'route' => 'surgeries.index', 'icon' => 'folder'],
            ['name' => 'سجل المرضى', 'route' => 'patients.index', 'icon' => 'folder'],
            ['name' => 'جدول المواعيد', 'route' => 'appointments.index', 'icon' => 'folder'],
            ['name' => 'الإعدادات', 'route' => 'settings.index', 'icon' => 'folder'],
        ];

        if (Auth::user()->role === 'doctor') {
            $sections[] = ['name' => 'الحسابات', 'route' => 'billing.index', 'icon' => 'folder'];
        }

        foreach ($sections as $section) {
            if (mb_stripos($section['name'], $query) !== false) {
                $results[] = [
                    'type' => 'section',
                    'title' => $section['name'],
                    'subtitle' => 'قسم',
                    'url' => route($section['route']),
                    'icon' => 'folder'
                ];
            }
        }

        return response()->json($results);
    }
}
