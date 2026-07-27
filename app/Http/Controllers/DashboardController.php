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

        $pendingAppointments = Appointment::where('tenant_id', auth()->user()->tenant_id)
            ->where('status', 'pending')
            ->get();

        foreach ($pendingAppointments as $appt) {
            if ($appt->appointment_date && $appt->appointment_time) {
                $dateTimeString = $appt->appointment_date->format('Y-m-d') . ' ' . $appt->appointment_time;
                if (\Carbon\Carbon::parse($dateTimeString, 'Asia/Baghdad')->isPast()) {
                    $appt->update(['status' => 'cancelled']);
                }
            }
        }

        $appointmentStatus = $request->query('appointment_status', 'pending');

        $todaysAppointmentsQuery = Appointment::with('patient')
            ->where('tenant_id', auth()->user()->tenant_id)
            ->where('appointment_date', today()->format('Y-m-d'));

        if ($appointmentStatus !== 'all') {
            $todaysAppointmentsQuery->where('status', $appointmentStatus);
        }

        $todaysAppointments = $todaysAppointmentsQuery->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        $recentAppointments = Appointment::with('patient')
            ->where('tenant_id', auth()->user()->tenant_id)
            ->where('appointment_date', today()->format('Y-m-d'))
            ->orderBy('appointment_time', 'asc')
            ->take(5)
            ->get();

        $activeConsultation = Appointment::with('patient')
            ->where('tenant_id', auth()->user()->tenant_id)
            ->where('status', 'in_progress')
            ->first();

        // Calculations for Dashboard Stats
        $filter = $request->query('filter', 'today');
        $query = Appointment::where('tenant_id', auth()->user()->tenant_id)->where('status', 'completed');

        switch ($filter) {
            case 'week':
                $query->where('appointment_date', '>=', now()->startOfWeek());
                break;
            case 'month':
                $query->where('appointment_date', '>=', now()->startOfMonth());
                break;
            case 'year':
                $query->where('appointment_date', '>=', now()->startOfYear());
                break;
            case 'today':
            default:
                $query->where('appointment_date', today()->format('Y-m-d'));
                break;
        }

        $visitorsCount = $query->count();

        // Revenue Calculations
        $revenuePeriod = $request->query('revenue_period', 'today');
        $revenueDate = $request->query('revenue_date');
        $revenueQuery = Appointment::where('tenant_id', auth()->user()->tenant_id)->where('status', 'completed');

        if ($revenueDate) {
            $revenueQuery->where('appointment_date', $revenueDate);
        } else {
            switch ($revenuePeriod) {
                case 'week':
                    $revenueQuery->where('appointment_date', '>=', now()->startOfWeek());
                    break;
                case 'month':
                    $revenueQuery->where('appointment_date', '>=', now()->startOfMonth());
                    break;
                case 'year':
                    $revenueQuery->where('appointment_date', '>=', now()->startOfYear());
                    break;
                case 'all':
                    break;
                case 'today':
                default:
                    $revenueQuery->where('appointment_date', today()->format('Y-m-d'));
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
