<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $hour = \Carbon\Carbon::now('Asia/Baghdad')->hour;
        $name = auth()->user()->name;
        $greeting = $hour < 12 ? "صباح الخير $name" : "مساء الخير $name";

        if (strtolower(auth()->user()->role) === 'doctor') {
            $todaysAppointments = Appointment::with('patient')
                ->where('tenant_id', auth()->user()->tenant_id)
                ->where('appointment_date', today()->format('Y-m-d'))
                ->orderBy('queue_number', 'asc')
                ->get();
            return view('doctor.dashboard', compact('todaysAppointments', 'greeting'));
        }

        $pendingAppointments = Appointment::where('tenant_id', auth()->user()->tenant_id)
            ->where('status', 'pending')
            ->get();

        foreach ($pendingAppointments as $appt) {
            if ($appt->appointment_date && $appt->appointment_time) {
                $dateTimeString = $appt->appointment_date->format('Y-m-d') . ' ' . $appt->appointment_time;
                $appointmentDateTime = \Carbon\Carbon::parse($dateTimeString, 'Asia/Baghdad');

                // If more than 15 minutes overdue, generate notification for secretary
                if (\Carbon\Carbon::now('Asia/Baghdad')->diffInMinutes($appointmentDateTime, false) < -15) {
                    $cacheKey = 'notified_overdue_' . $appt->id;
                    if (!\Illuminate\Support\Facades\Cache::has($cacheKey)) {
                        $patientName = $appt->patient->name ?? $appt->patient_name;
                        $message = "المراجع {$patientName} تجاوز وقت موعده، هل تريد التواصل معه؟";

                        $secretaries = \App\Models\User::where('tenant_id', auth()->user()->tenant_id)
                            ->where('role', '!=', 'Doctor') // Assuming non-doctors are secretaries/staff
                            ->get();

                        foreach ($secretaries as $secretary) {
                            $secretary->notify(new \App\Notifications\GeneralNotification($message, 'warning', 'clock'));
                        }

                        \Illuminate\Support\Facades\Cache::put($cacheKey, true, now()->addHours(24));
                    }
                }

                // Kept original auto-cancel logic if needed, but adjusted to perhaps not cancel immediately if we are notifying
                // For now, if we cancel it immediately, they might not see the notification action.
                // We'll keep the original logic but ONLY if it's REALLY past (e.g. end of day)
                // Actually, original code cancels immediately if past. Let's adjust to cancel if > 2 hours past to allow them to be overdue.
                if (\Carbon\Carbon::now('Asia/Baghdad')->diffInMinutes($appointmentDateTime, false) < -120) {
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
            'revenueDate',
            'greeting'
        ));
    }
}
