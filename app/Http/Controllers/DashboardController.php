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

        $appointmentStatus = $request->query('appointment_status', 'pending');

        $todaysAppointmentsQuery = Appointment::with('patient')
            ->whereDate('appointment_datetime', today());

        if ($appointmentStatus !== 'all') {
            $todaysAppointmentsQuery->where('status', $appointmentStatus);
        }

        $todaysAppointments = $todaysAppointmentsQuery->orderBy('appointment_datetime', 'asc')
            ->get();

        $recentAppointments = $todaysAppointments->take(5);

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

        // Revenue Calculations
        $revenuePeriod = $request->query('revenue_period', 'today');
        $revenueDate = $request->query('revenue_date');
        $revenueQuery = Appointment::where('status', 'completed');

        if ($revenueDate) {
            $revenueQuery->whereDate('appointment_datetime', $revenueDate);
        } else {
            switch ($revenuePeriod) {
                case 'week':
                    $revenueQuery->where('appointment_datetime', '>=', now()->startOfWeek());
                    break;
                case 'month':
                    $revenueQuery->where('appointment_datetime', '>=', now()->startOfMonth());
                    break;
                case 'year':
                    $revenueQuery->where('appointment_datetime', '>=', now()->startOfYear());
                    break;
                case 'all':
                    break;
                case 'today':
                default:
                    $revenueQuery->whereDate('appointment_datetime', today());
                    break;
            }
        }

        $totalRevenue = $revenueQuery->sum('price');

        // Preparing variables for future columns
        $pendingSurgeries = 0;
        $todaySessions = 0;

        $recentCalls = collect([]);
        $recentMessages = collect([]);

        return view('dashboard', compact(
            'todaysAppointments',
            'recentAppointments',
            'activeConsultation',
            'pendingSurgeries',
            'todaySessions',
            'recentCalls',
            'recentMessages',
            'visitorsCount',
            'totalRevenue',
            'filter',
            'appointmentStatus',
            'revenuePeriod',
            'revenueDate'
        ));
    }
}
