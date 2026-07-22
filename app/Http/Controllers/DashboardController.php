<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class DashboardController extends Controller
{
    public function index()
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
            'recentMessages'
        ));
    }
}
