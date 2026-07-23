<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (strtolower(auth()->user()->role) === 'doctor') {
            return view('doctor.dashboard');
        }

        $todaysAppointments = Appointment::with('patient')
            ->whereDate('appointment_datetime', today())
            ->orderBy('appointment_datetime', 'asc')
            ->take(5)
            ->get();

        $activeConsultation = Appointment::with('patient')
            ->where('status', 'in_progress')
            ->first();

        // Calculations for Dashboard Stats
        $filter = $request->query('filter', 'today');
        $query = Appointment::where('status', 'completed');

        switch ($filter) {
            case 'week':
                $query->where('appointment_datetime', '>=', now()->startOfWeek());
                break;
            case 'month':
                $query->where('appointment_datetime', '>=', now()->startOfMonth());
                break;
            case 'year':
                $query->where('appointment_datetime', '>=', now()->startOfYear());
                break;
            case 'today':
            default:
                $query->whereDate('appointment_datetime', today());
                break;
        }

        $visitorsCount = $query->count();
        $totalRevenue = $query->sum('price');

        // Preparing variables for future columns
        $pendingSurgeries = 0;
        $todaySessions = 0;

        $recentCalls = collect([]);
        $recentMessages = collect([]);

        return view('dashboard', compact(
            'todaysAppointments',
            'activeConsultation',
            'pendingSurgeries',
            'todaySessions',
            'recentCalls',
            'recentMessages',
            'visitorsCount',
            'totalRevenue',
            'filter'
        ));
    }
}
