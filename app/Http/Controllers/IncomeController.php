<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use App\Income;
use App\Cost;
use Carbon\Carbon;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::paginate(10);
        $totalSum = Income::sum('quantity');

        $sumMonthBefore = Income::where('income_date', '>', Carbon::now()->subMonths(1)->startOfMonth())
                                ->where('income_date', '<', Carbon::now()->subMonths(1)->endOfMonth())
                                ->sum('quantity');

        $sumCurrentMonth = Income::where('income_date', '>', Carbon::now()->startOfMonth())
                                ->where('income_date', '<', Carbon::now())
                                ->sum('quantity');

        $years = Income::select(DB::raw('YEAR(income_date) as year'))
                        ->groupBy(DB::raw('YEAR(income_date)'))
                        ->get();
        
        $incomeDataset = Income::select(DB::raw('SUM(quantity) as sum, DAY(income_date) as day, MONTH(income_date) as month, YEAR(income_date) as year'))
                                ->whereMonth('income_date', Carbon::now()->month)
                                ->whereYear('income_date', Carbon::now()->year)
                                ->groupBy('income_date')
                                ->get();

        $date = $incomeDataset->map(function($item) {
            $month = (['Januari', 'Februari', 'Maret',
                    'April', 'Mei', 'Juni', 'Juli',
                    'Agustus', 'September', 'Oktober',
                    'November', 'Desember'])[intval($item->month) - 1];

            return strval($item->day) . ' ' . strval($month) . ' ' . strval($item->year);
        });

        $sums = $incomeDataset->map(function($item) {
            return $item->sum / 1000;
        });

        return view('content.income.index', [
            'title' => 'Riwayat Penghasilan Keseluruhan',
            'incomes' => $incomes,
            'totalSum' => $totalSum,
            'sumMonthBefore' => $sumMonthBefore,
            'sumCurrentMonth' => $sumCurrentMonth,
            'years' => $years,
            'date' => $date,
            'sums' => $sums,
            'user' => false,
        ]);
    }

    public function userIncome()
    {
        $projects = Auth::user()->projects->pluck('id');

        $costs = Cost::whereIn('project_id', $projects)->get()->pluck('id');
        
        $incomes = Income::whereIn('cost_id', $costs)->paginate(10);
        
        $quantities = Income::whereIn('cost_id', $costs)->get()->pluck('quantity');

        $totalSum = $quantities->reduce(function($carry, $item) {
            return $carry + $item;
        });

        $sumMonthBefore = Income::whereIn('cost_id', $costs)
                                ->where('income_date', '>', Carbon::now()->subMonths(1)->startOfMonth())
                                ->where('income_date', '<', Carbon::now()->subMonths(1)->endOfMonth())
                                ->sum('quantity');

        $sumCurrentMonth = Income::whereIn('cost_id', $costs)
                                ->where('income_date', '>', Carbon::now()->startOfMonth())
                                ->where('income_date', '<', Carbon::now())
                                ->sum('quantity');
        
        $years = Income::select(DB::raw('YEAR(income_date) as year'))
                        ->groupBy(DB::raw('YEAR(income_date)'))
                        ->get();
                        
        $incomeDataset = Income::select(DB::raw('SUM(quantity) as sum, DAY(income_date) as day, MONTH(income_date) as month, YEAR(income_date) as year'))
                                ->whereIn('cost_id', $costs)
                                ->whereMonth('income_date', Carbon::now()->month)
                                ->whereYear('income_date', Carbon::now()->year)
                                ->groupBy('income_date')
                                ->get();

        $date = $incomeDataset->map(function($item) {
            $month = (['Januari', 'Februari', 'Maret',
                    'April', 'Mei', 'Juni', 'Juli',
                    'Agustus', 'September', 'Oktober',
                    'November', 'Desember'])[intval($item->month) - 1];

            return strval($item->day) . ' ' . strval($month) . ' ' . strval($item->year);
        });

        $sums = $incomeDataset->map(function($item) {
            return $item->sum / 1000;
        });

        return view('content.income.index', [
            'title' => 'Riwayat Penghasilan Sendiri',
            'incomes' => $incomes,
            'totalSum' => $totalSum,
            'sumMonthBefore' => $sumMonthBefore,
            'sumCurrentMonth' => $sumCurrentMonth,
            'years' => $years,
            'date' => $date,
            'sums' => $sums,
            'user' => Auth::id(),
        ]);
    }

    public function incomeChart(Request $request)
    {
        $month = $request->has('month') ? $request->month : false;
        $year = $request->year;
        
        if($month && $year) {
            $incomes = Income::select(DB::raw('SUM(quantity) as sum, DAY(income_date) as day, MONTH(income_date) as month, YEAR(income_date) as year'))
                                ->whereMonth('income_date', $month)
                                ->whereYear('income_date', $year)
                                ->groupBy('income_date')
                                ->get();
        }
        else {
            $incomes = Income::select(DB::raw('SUM(quantity) as sum,  MONTH(income_date) as month'))
                                ->whereYear('income_date', $year)
                                ->groupBy('month')
                                ->get();
        }

        return $incomes;
    }

    public function userIncomeChart(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $projects = $user->projects->pluck('id');
        $costs = Cost::whereIn('project_id', $projects)->get()->pluck('id');

        $month = $request->has('month') ? $request->month : false;
        $year = $request->year;

        if ($month && $year) {
            $incomes = Income::select(DB::raw('SUM(quantity) as sum, DAY(income_date) as day, MONTH(income_date) as month, YEAR(income_date) as year'))
                                ->whereIn('cost_id', $costs)
                                ->whereMonth('income_date', $month)
                                ->whereYear('income_date', $year)
                                ->groupBy('income_date')
                                ->get();
        }
        else {
            $incomes = Income::select(DB::raw('SUM(quantity) as sum,  MONTH(income_date) as month'))
                                ->whereIn('cost_id', $costs)
                                ->whereYear('income_date', $year)
                                ->groupBy('month')
                                ->get();
        }

        return $incomes;
    }
}
