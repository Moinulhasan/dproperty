<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Property;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $stats = [
            'total_properties' => 0,
            'total_companies' => 0,
            'total_users' => 0,
            'recent_properties' => []
        ];

        // Base Query for Charts
        $propertyQuery = Property::query();

        if ($user->hasRole('Super Admin')) {
            $stats['total_properties'] = Property::count();
            $stats['total_companies'] = Company::count();
            $stats['total_users'] = User::count();
            $stats['recent_properties'] = Property::latest()->take(5)->get();
        } elseif ($user->hasRole('Property Admin')) {
            $stats['total_properties'] = $user->company->properties()->count();
            $stats['total_users'] = User::where('company_id', $user->company_id)->count();
            $stats['recent_properties'] = $user->company->properties()->latest()->take(5)->get();
            $propertyQuery->whereIn('created_by', User::where('company_id', $user->company_id)->pluck('id'));
        } else {
            $stats['total_properties'] = Property::where('created_by', $user->id)->count();
            $stats['recent_properties'] = Property::where('created_by', $user->id)->latest()->take(5)->get();
            $propertyQuery->where('created_by', $user->id);
        }

        // Chart 1: Property Status Distribution
        $statusCounts = (clone $propertyQuery)
            ->select('property_status', DB::raw('count(*) as total'))
            ->groupBy('property_status')
            ->pluck('total', 'property_status')
            ->toArray();
        
        $chartData['status'] = [
            'labels' => array_keys($statusCounts),
            'series' => array_values($statusCounts)
        ];

        // Chart 2: Monthly Creation Trends (Last 6 Months)
        $monthlyTrends = (clone $propertyQuery)
            ->select(
                DB::raw('COUNT(*) as count'),
                DB::raw('DATE_FORMAT(created_at, "%b") as month'),
                DB::raw('MONTH(created_at) as month_num')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month', 'month_num')
            ->orderBy('month_num')
            ->get();

        $chartData['trends'] = [
            'labels' => $monthlyTrends->pluck('month')->toArray(),
            'series' => $monthlyTrends->pluck('count')->toArray()
        ];

        return view('admin.dashboard.index', compact('stats', 'chartData'));
    }
}
