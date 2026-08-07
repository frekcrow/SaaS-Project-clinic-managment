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
        $greeting = $hour < 12 ? __('صباح الخير') . " $name" : __('مساء الخير') . " $name";

        if (strtolower(auth()->user()->role) === 'doctor') {
            $todaysAppointments = Appointment::with('patient')
                ->where('tenant_id', auth()->user()->tenant_id)
                ->where('appointment_date', today()->format('Y-m-d'))
                ->orderBy('queue_number', 'asc')
                ->get();

            $pendingSurgeries = \App\Models\Surgery::where('tenant_id', auth()->user()->tenant_id)
                ->whereDate('surgery_date', today()->format('Y-m-d'))
                ->count();

            $surgeryTypes = \App\Models\SurgeryType::where('tenant_id', auth()->user()->tenant_id)->get();
            $patients = \App\Models\Patient::where('tenant_id', auth()->user()->tenant_id)->orderBy('name')->get();

            // Financial Calculations
            $totalIncome = Appointment::where('tenant_id', auth()->user()->tenant_id)
                ->where('status', 'completed')
                ->sum('price');

            $surgeriesQuery = \App\Models\Surgery::where('tenant_id', auth()->user()->tenant_id);
            $totalSurgeryIncome = $surgeriesQuery->sum('cost');
            $completedSurgeriesCount = $surgeriesQuery->count();
            $avgSurgeryIncome = $completedSurgeriesCount > 0 ? $totalSurgeryIncome / $completedSurgeriesCount : 0;

            // Dummy logic for expenses / net worth since there is no Expense model/table.
            // In a real application, you'd calculate these from an expenses table.
            $totalExpenses = 0;
            $paidExpenses = 0;
            $unpaidExpenses = 0;
            $netWorth = $totalIncome + $totalSurgeryIncome - $totalExpenses;

            // Real Analytics Data for Doctor Dashboard
            $tenantId = auth()->user()->tenant_id;

            // 1. Gender Distribution
            $genderCounts = \App\Models\Patient::where('tenant_id', $tenantId)
                ->selectRaw('gender, count(*) as count')
                ->groupBy('gender')
                ->pluck('count', 'gender')
                ->toArray();

            $maleCount = $genderCounts['male'] ?? 0;
            $femaleCount = $genderCounts['female'] ?? 0;

            // 2. Common Diseases (from MedicalRecords diagnosis)
            $diseases = \App\Models\MedicalRecord::where('tenant_id', $tenantId)
                ->whereNotNull('diagnosis')
                ->where('diagnosis', '!=', '')
                ->where('diagnosis', '!=', 'قيد الانتظار')
                ->selectRaw('diagnosis, count(*) as count')
                ->groupBy('diagnosis')
                ->orderByDesc('count')
                ->limit(5)
                ->get();

            $diseasesLabels = $diseases->pluck('diagnosis')->toArray();
            $diseasesData = $diseases->pluck('count')->toArray();

            // 3. Age Distribution
            $ages = \App\Models\Patient::where('tenant_id', $tenantId)
                ->whereNotNull('dob')
                ->get()
                ->map(function ($patient) {
                    return \Carbon\Carbon::parse($patient->dob)->age;
                });

            $ageGroups = [
                '0-18' => $ages->filter(fn($age) => $age <= 18)->count(),
                '19-30' => $ages->filter(fn($age) => $age >= 19 && $age <= 30)->count(),
                '31-45' => $ages->filter(fn($age) => $age >= 31 && $age <= 45)->count(),
                '46-60' => $ages->filter(fn($age) => $age >= 46 && $age <= 60)->count(),
                '60+' => $ages->filter(fn($age) => $age > 60)->count(),
            ];

            // 4. Common Medications (from MedicalRecords prescription)
            $medications = \App\Models\MedicalRecord::where('tenant_id', $tenantId)
                ->whereNotNull('prescription')
                ->where('prescription', '!=', '')
                ->selectRaw('prescription, count(*) as count')
                ->groupBy('prescription')
                ->orderByDesc('count')
                ->limit(5)
                ->get();

            $medicationsLabels = $medications->pluck('prescription')->toArray();
            $medicationsData = $medications->pluck('count')->toArray();

            // 5. Surgeries (by Type)
            $surgeriesByType = \App\Models\Surgery::with('surgeryType')
                ->where('tenant_id', $tenantId)
                ->selectRaw('surgery_type_id, count(*) as count')
                ->groupBy('surgery_type_id')
                ->orderByDesc('count')
                ->limit(5)
                ->get();

            $surgeriesLabels = $surgeriesByType->map(fn($s) => $s->surgeryType->name ?? 'غير محدد')->toArray();
            $surgeriesData = $surgeriesByType->pluck('count')->toArray();

            // Financial Data over the last 7 days
            $last7Days = collect(range(6, 0))->map(function ($days) {
                return now()->subDays($days)->format('Y-m-d');
            });

            $revenueByDay = \App\Models\Appointment::where('tenant_id', $tenantId)
                ->where('status', 'completed')
                ->where('appointment_date', '>=', now()->subDays(6)->format('Y-m-d'))
                ->selectRaw('appointment_date, sum(price) as total')
                ->groupBy('appointment_date')
                ->pluck('total', 'appointment_date')
                ->toArray();

            $financeLabels = [];
            $financeData = [];
            foreach ($last7Days as $day) {
                $financeLabels[] = \Carbon\Carbon::parse($day)->format('m/d');
                $financeData[] = $revenueByDay[$day] ?? 0;
            }

            return view('doctor.dashboard', compact(
                'todaysAppointments', 'greeting', 'pendingSurgeries', 'surgeryTypes', 'patients',
                'totalIncome', 'totalSurgeryIncome', 'avgSurgeryIncome',
                'totalExpenses', 'paidExpenses', 'unpaidExpenses', 'netWorth',
                'maleCount', 'femaleCount', 'diseasesLabels', 'diseasesData',
                'ageGroups', 'medicationsLabels', 'medicationsData',
                'surgeriesLabels', 'surgeriesData',
                'financeLabels', 'financeData'
            ));
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
        $pendingSurgeries = \App\Models\Surgery::where('tenant_id', auth()->user()->tenant_id)
            ->whereDate('surgery_date', today()->format('Y-m-d'))
            ->count();

        $todaySessionsCount = \App\Models\Appointment::where('tenant_id', auth()->user()->tenant_id)
            ->where('appointment_date', today()->format('Y-m-d'))
            ->where('is_session', true)
            ->where('status', 'pending')
            ->count();

        $recentCalls = collect([]);
        $recentMessages = collect([]);

        return view('dashboard', compact(
            'todaysAppointments',
            'recentAppointments',
            'activeConsultation',
            'pendingSurgeries',
            'todaySessionsCount',
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
