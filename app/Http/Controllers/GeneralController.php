<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Project;
use App\Cost;
use App\Income;
use App\Weight;

class GeneralController extends Controller
{
    public function dashboard()
    {
        $userCount = User::count();
        $adminCount = User::where('access', 1)->count();
        $operatorCount = User::where('access', 2)->count();
        $managerCount = User::where('access', 3)->count();
        
        $weight = Weight::latest()->first();
        $totalIncomes = Income::sum('quantity');
        $incomes = Income::select(DB::raw('SUM(quantity) as sum, MONTH(income_date) as month, YEAR(income_date) as year'))
                                ->groupBy(DB::raw('YEAR(income_date) ASC, MONTH(income_date) ASC'))
                                ->get();

        $totalProjects = '';
        $inprogressProjects = '';
        $completedProjects = '';
        $failedProjects = '';
        $weightSum = '';

        if (Auth::user()->access === 1) {
            $totalProjects = Project::count();
            $inprogressProjects = Project::where('project_status', 3)->count();
            $completedProjects = Project::where('project_status', 4)->count();
            $failedProjects = Project::where('project_status', 1)->count();
            
            $weightSum = Weight::count();
        }

        else if (Auth::user()->access === 3) {
            $totalProjects = Project::where('user_id', Auth::id())->count();
            $inprogressProjects = Project::where('project_status', 3)
                                            ->where('user_id', Auth::id())
                                            ->count();
            $completedProjects = Project::where('project_status', 4)
                                            ->where('user_id', Auth::id())
                                            ->count();
            $failedProjects = Project::where('project_status', 1)
                                        ->where('user_id', Auth::id())
                                        ->count();

            $projects = Auth::user()->projects->pluck('id');

            $costs = Cost::whereIn('project_id', $projects)->get()->pluck('id');
            $quantities = Income::whereIn('cost_id', $costs)->get()->pluck('quantity');

            $totalIncomes = $quantities->reduce(function($carry, $item) {
                return $carry + $item;
            });

            $incomes = Income::select(DB::raw('SUM(quantity) as sum, MONTH(income_date) as month, YEAR(income_date) as year'))
                                ->groupBy(DB::raw('YEAR(income_date) ASC, MONTH(income_date) ASC'))
                                ->whereIn('cost_id', $costs)
                                ->get();
        }
        
        else {
            $totalProjects = Project::count();
            $inprogressProjects = Project::where('project_status', 3)->count();
            $completedProjects = Project::where('project_status', 4)->count();
            $failedProjects = Project::where('project_status', 1)->count();
            
            $weightSum = Weight::where('user_id', Auth::id())->count();
        }

        return view('content.dashboard', [
            'userCount' => $userCount,
            'adminCount' => $adminCount,
            'operatorCount' => $operatorCount,
            'managerCount' => $managerCount,
            
            'weight' => $weight,
            'weightSum' => $weightSum,

            'totalProjects' => $totalProjects,
            'inprogressProjects' => $inprogressProjects,
            'completedProjects' => $completedProjects,
            'failedProjects' => $failedProjects,

            'totalIncomes' => $totalIncomes,
            'incomes' => $incomes,
        ]);
    }

    public function search(Request $request)
    {
        $typeParameter = intval($request->type_parameter);
        $dataParameter = intval($request->data_parameter);
        $keyword = '%' . $request->search_keyword . '%';

        $users = [];
        $projects = [];

        if ($typeParameter === 1) {
            $column = (['name', 'username', 'phone_number'])[ $dataParameter - 1 ];
            $users = User::where($column, 'like', $keyword)->get();

            if (count($users) === 1) {
                $user = $users->first();
                return redirect()->route('pengguna.show', $user->id);
            }
        }
        else {
            $column = (['title', 'client_name', 'instance_name'])[ $dataParameter - 1 ];
            $projects = Project::where($column, 'like', $keyword)->get();

            if (count($projects) === 1) {
                $project = $projects->first();

                return redirect()->route('proyek.show', $project->id);
            }
        }

        return view('content.search', [
            'users' => $users,
            'projects' => $projects,
        ]);
    }
}
