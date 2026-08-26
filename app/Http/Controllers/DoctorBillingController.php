<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Surgery;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DoctorBillingController extends Controller
{
    public function index(Request $request)
    {
        $tenantId = Auth::user()->tenant_id;
        $today = Carbon::today('Asia/Baghdad')->format('Y-m-d');

        $allSecretaries = User::where('tenant_id', $tenantId)->where('role', 'Secretary')->get();
        $secretaryId = $request->query('secretary_id');

        // Top Stats
        // 1. Total Patients Today (Count of appointments strictly for today)
        $totalPatientsTodayQuery = Appointment::where('tenant_id', $tenantId)
            ->where('appointment_date', $today);

        // 2. Today's Income (Sum of session/consultation fees collected today for completed appointments)
        $todayIncomeQuery = Appointment::where('tenant_id', $tenantId)
            ->where('appointment_date', $today)
            ->whereIn('status', ['arrived', 'in_progress', 'completed']);

        // 3. Total Surgeries Income (Sum of surgery costs for all surgeries)
        $totalSurgeriesIncomeQuery = Surgery::where('tenant_id', $tenantId);

        // 4. Net Worth (Total overall income: sessions + surgeries)
        $totalSessionsIncomeQuery = Appointment::where('tenant_id', $tenantId)
            ->whereIn('status', ['arrived', 'in_progress', 'completed']);

        if ($secretaryId) {
            $totalPatientsTodayQuery->where('created_by', $secretaryId);
            $todayIncomeQuery->where('created_by', $secretaryId);
            $totalSurgeriesIncomeQuery->where('created_by', $secretaryId);
            $totalSessionsIncomeQuery->where('created_by', $secretaryId);
        }

        $totalPatientsToday = $totalPatientsTodayQuery->count();
        $todayIncome = $todayIncomeQuery->sum('price');
        $totalSurgeriesIncome = $totalSurgeriesIncomeQuery->sum('cost');
        $totalSessionsIncome = $totalSessionsIncomeQuery->sum('price');

        $netWorth = $totalSessionsIncome + $totalSurgeriesIncome;

        // Sorting
        $sortOrder = $request->input('sort', 'desc');
        $validSorts = ['desc', 'asc'];
        if (!in_array($sortOrder, $validSorts)) {
            $sortOrder = 'desc';
        }

        // Top Paying Patients List
        // Calculate total amount paid by each patient (appointments + surgeries)
        // We use left joins with subqueries to group first, preventing Cartesian product duplication.

        $appointmentsSubquery = Appointment::select('patient_id', DB::raw('SUM(price) as total_appointments_paid'))
            ->where('tenant_id', $tenantId)
            ->whereIn('status', ['arrived', 'in_progress', 'completed'])
            ->whereNotNull('patient_id')
            ->groupBy('patient_id');

        $surgeriesSubquery = Surgery::select('patient_id', DB::raw('SUM(cost) as total_surgeries_paid'))
            ->where('tenant_id', $tenantId)
            ->whereNotNull('patient_id')
            ->groupBy('patient_id');

        if ($secretaryId) {
            $appointmentsSubquery->where('created_by', $secretaryId);
            $surgeriesSubquery->where('created_by', $secretaryId);
        }

        $patientsData = Patient::where('patients.tenant_id', $tenantId)
            ->leftJoinSub($appointmentsSubquery, 'a_sub', function ($join) {
                $join->on('patients.id', '=', 'a_sub.patient_id');
            })
            ->leftJoinSub($surgeriesSubquery, 's_sub', function ($join) {
                $join->on('patients.id', '=', 's_sub.patient_id');
            })
            ->select(
                'patients.id',
                'patients.name',
                'patients.phone',
                DB::raw('COALESCE(a_sub.total_appointments_paid, 0) + COALESCE(s_sub.total_surgeries_paid, 0) as total_paid')
            )
            ->whereRaw('(COALESCE(a_sub.total_appointments_paid, 0) + COALESCE(s_sub.total_surgeries_paid, 0)) > 0')
            ->orderBy('total_paid', $sortOrder)
            ->get();

        // Secretary Revenue Stats
        $secretariesCount = User::where('tenant_id', $tenantId)->where('role', 'Secretary')->count();
        $secretaryStats = collect();

        if ($secretariesCount > 1) {
            $secretaries = User::where('tenant_id', $tenantId)->where('role', 'Secretary')->get();
            $startOfDay = Carbon::today('Asia/Baghdad');
            $startOfWeek = Carbon::now('Asia/Baghdad')->startOfWeek();
            $startOfMonth = Carbon::now('Asia/Baghdad')->startOfMonth();

            foreach ($secretaries as $secretary) {
                $dailyAppt = Appointment::where('tenant_id', $tenantId)
                    ->where('created_by', $secretary->id)
                    ->whereIn('status', ['arrived', 'in_progress', 'completed'])
                    ->whereDate('appointment_date', $startOfDay)
                    ->sum('price');
                $dailySurg = Surgery::where('tenant_id', $tenantId)
                    ->where('created_by', $secretary->id)
                    ->whereDate('surgery_date', $startOfDay)
                    ->sum('cost');

                $weeklyAppt = Appointment::where('tenant_id', $tenantId)
                    ->where('created_by', $secretary->id)
                    ->whereIn('status', ['arrived', 'in_progress', 'completed'])
                    ->whereDate('appointment_date', '>=', $startOfWeek)
                    ->sum('price');
                $weeklySurg = Surgery::where('tenant_id', $tenantId)
                    ->where('created_by', $secretary->id)
                    ->whereDate('surgery_date', '>=', $startOfWeek)
                    ->sum('cost');

                $monthlyAppt = Appointment::where('tenant_id', $tenantId)
                    ->where('created_by', $secretary->id)
                    ->whereIn('status', ['arrived', 'in_progress', 'completed'])
                    ->whereDate('appointment_date', '>=', $startOfMonth)
                    ->sum('price');
                $monthlySurg = Surgery::where('tenant_id', $tenantId)
                    ->where('created_by', $secretary->id)
                    ->whereDate('surgery_date', '>=', $startOfMonth)
                    ->sum('cost');

                $secretaryStats->push((object)[
                    'name' => $secretary->name,
                    'daily' => $dailyAppt + $dailySurg,
                    'weekly' => $weeklyAppt + $weeklySurg,
                    'monthly' => $monthlyAppt + $monthlySurg,
                ]);
            }
        }

        return view('doctor.billing.index', compact(
            'totalPatientsToday',
            'todayIncome',
            'totalSurgeriesIncome',
            'netWorth',
            'patientsData',
            'sortOrder',
            'secretariesCount',
            'secretaryStats',
            'allSecretaries',
            'secretaryId'
        ));
    }
}
