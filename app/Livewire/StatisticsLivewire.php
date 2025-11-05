<?php

namespace App\Livewire;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class StatisticsLivewire extends Component
{
    public $auth;
    public $filterMonth;
    public $filterYear;

    public function mount()
    {
        $this->auth = Auth::user();
        $this->filterMonth = now()->format('m');
        $this->filterYear = now()->format('Y');
    }

    public function render()
    {
        $userId = $this->auth->id;
        $month = $this->filterMonth;
        $year = $this->filterYear;

        // Total Income & Expense
        $totalIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->sum('amount');

        $totalExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->sum('amount');

        $balance = $totalIncome - $totalExpense;

        // Transactions by Category
        $categoryData = Transaction::where('user_id', $userId)
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->select('category', 'type', DB::raw('SUM(amount) as total'))
            ->groupBy('category', 'type')
            ->get();

        // Monthly Trend (12 months)
        $monthlyTrend = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $m = $date->format('m');
            $y = $date->format('Y');

            $income = Transaction::where('user_id', $userId)
                ->where('type', 'income')
                ->whereYear('transaction_date', $y)
                ->whereMonth('transaction_date', $m)
                ->sum('amount');

            $expense = Transaction::where('user_id', $userId)
                ->where('type', 'expense')
                ->whereYear('transaction_date', $y)
                ->whereMonth('transaction_date', $m)
                ->sum('amount');

            $monthlyTrend[] = [
                'month' => $date->format('M Y'),
                'income' => $income,
                'expense' => $expense
            ];
        }

        // Recent Transactions
        $recentTransactions = Transaction::where('user_id', $userId)
            ->orderBy('transaction_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $data = [
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
            'categoryData' => $categoryData,
            'monthlyTrend' => $monthlyTrend,
            'recentTransactions' => $recentTransactions
        ];

        return view('livewire.statistics-livewire', $data);
    }
}