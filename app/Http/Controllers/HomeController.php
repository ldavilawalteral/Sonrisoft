<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tenantId = auth()->user()->tenant_id;

        // 1. KPIs
        $totalPatients = Patient::count(); // Scoped by global scope usually, but good to be safe if it fails. The trait is on Patient model.

        $upcomingAppointments = Appointment::where('scheduled_at', '>=', now())
            ->orderBy('scheduled_at', 'asc')
            ->take(5)
            ->with('patient')
            ->get();

        $monthlyIncome = Payment::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        $annualIncome = Payment::whereYear('created_at', now()->year)
            ->sum('amount');

        // 2. Chart Data: Last 6 months income
        // We need labels ['Jan', 'Feb', ...] and data [100, 200, ...]

        $months = [];
        $incomePerMonth = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->format('M');
            $year = $date->year;
            $month = $date->month;

            $months[] = $monthName;

            $income = Payment::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->sum('amount');

            $incomePerMonth[] = $income;
        }

        return view('home', compact(
            'totalPatients',
            'upcomingAppointments',
            'monthlyIncome',
            'annualIncome',
            'months',
            'incomePerMonth'
        ));
    }
}
