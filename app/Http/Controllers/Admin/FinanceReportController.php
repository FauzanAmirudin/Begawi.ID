<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class FinanceReportController extends Controller
{
    /**
     * Check if current user is super admin
     */
    protected function checkSuperAdmin(): void
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user || $user->role !== User::ROLE_SUPER_ADMIN) {
            abort(403, 'Akses ditolak. Hanya Super Admin yang dapat mengakses halaman ini.');
        }
    }

    /**
     * Display financial reports
     */
    public function index(Request $request): View
    {
        $this->checkSuperAdmin();
        
        // Default to current month if not specified
        $month = $request->get('month', date('Y-m'));
        $year = $request->get('year', date('Y'));

        // Monthly revenue data for chart
        $monthlyRevenue = Transaction::where('status', 'success')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('CAST(SUM(amount) AS DECIMAL(10,2)) as total')
            )
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => $item->month,
                    'total' => (float) $item->total
                ];
            })
            ->values()
            ->toArray();

        // Daily revenue for selected month
        $dailyRevenue = Transaction::where('status', 'success')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('CAST(SUM(amount) AS DECIMAL(10,2)) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', date('Y', strtotime($month . '-01')))
            ->whereMonth('created_at', date('m', strtotime($month . '-01')))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->date,
                    'total' => (float) $item->total,
                    'count' => (int) $item->count
                ];
            })
            ->values()
            ->toArray();

        // Statistics
        $stats = [
            'total_revenue' => Transaction::where('status', 'success')->sum('amount'),
            'monthly_revenue' => Transaction::where('status', 'success')
                ->whereYear('created_at', date('Y', strtotime($month . '-01')))
                ->whereMonth('created_at', date('m', strtotime($month . '-01')))
                ->sum('amount'),
            'total_transactions' => Transaction::where('status', 'success')->count(),
            'monthly_transactions' => Transaction::where('status', 'success')
                ->whereYear('created_at', date('Y', strtotime($month . '-01')))
                ->whereMonth('created_at', date('m', strtotime($month . '-01')))
                ->count(),
            'average_transaction' => Transaction::where('status', 'success')->avg('amount'),
        ];

        // Revenue by package
        $revenueByPackage = Transaction::where('status', 'success')
            ->join('subscription_packages', 'transactions.subscription_package_id', '=', 'subscription_packages.id')
            ->select(
                'subscription_packages.name',
                DB::raw('SUM(transactions.amount) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('subscription_packages.id', 'subscription_packages.name')
            ->orderByDesc('total')
            ->get();

        // Revenue by payment method
        $revenueByPaymentMethod = Transaction::where('status', 'success')
            ->select(
                'payment_method',
                DB::raw('SUM(amount) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('payment_method')
            ->orderByDesc('total')
            ->get();

        return view('admin.finance.reports.index', compact(
            'month',
            'year',
            'monthlyRevenue',
            'dailyRevenue',
            'stats',
            'revenueByPackage',
            'revenueByPaymentMethod'
        ));
    }
}
