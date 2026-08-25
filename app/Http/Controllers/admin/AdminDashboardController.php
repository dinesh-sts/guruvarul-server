<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Register;
use Carbon\Carbon;

class AdminDashboardController extends Controller{
    
    public function index(){
        //Get Member Count
        $allMembersCount = Register::count();
        $approvedMembersCount = Register::where('status','Active')->count();
        $paidMembersCount = Register::where('status','Paid')->count();
        $featuredMembersCount = Register::where('fstatus','Featured')->count();

        //Total Earning
        $totalEarning = Payment::sum('p_amount');

        // Get last month earning
        $firstDayOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $lastDayOfLastMonth = Carbon::now()->subMonth()->endOfMonth();
        $lastMonthEarning = Payment::whereBetween('created_at', [$firstDayOfLastMonth, $lastDayOfLastMonth])->sum('p_amount');

        //Get last six months earning
        $sixMonths = Carbon::now()->subMonths(6);
        $lastSixMonthsEarning = Payment::where('created_at', '>=', $sixMonths)->sum('p_amount');

        //Get last year earning
        $startDate = Carbon::now()->subMonths(12)->startOfMonth();
        $lastYearEarning = Payment::whereBetween('created_at', [$startDate, $lastDayOfLastMonth])->sum('p_amount');

        //Recently Joined Members
        $recentlyJoinedProfiles = Register::latest()->take(8)->with('rel','cast')->get();

        // Chart data
        $earningsForLast12Months = [];
        $months = [];

        for ($i = 0; $i < 12; $i++) {
            $month = Carbon::now()->subMonths($i)->startOfMonth();
            $monthLabel = $month->format('M Y');
            $months[] = $monthLabel;

            $earningsForLast12Months[$monthLabel] = Payment::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('p_amount');
        }

        $months = array_reverse($months);
        $earningsForLast12Months = $earningsForLast12Months;
        
        $filteredEarnings = array_filter($earningsForLast12Months, function ($value) {
            return true;
        });
        
        $filteredEarnings = array_values($filteredEarnings);

        return view('admin.dashboard',compact('filteredEarnings','allMembersCount','approvedMembersCount','paidMembersCount','featuredMembersCount','totalEarning','lastMonthEarning','lastSixMonthsEarning','lastYearEarning','recentlyJoinedProfiles'));

    }
    
}
