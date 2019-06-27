<?php

namespace App\Http\Middleware;

use Closure;
use App\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ProjectCountMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->access === 1) {
            $n1 = Project::withCount('features')
                        ->where('payment_status', 1)
                        ->where('project_status', 2)
                        ->get()->count();

            $n2 = Project::with('cost')->where('payment_status', 2)
                        ->where('project_status', 2)
                        ->get()->count();

            $n3 = Project::where('project_status', 3)
                        ->get()->count();

            $n4 = Project::where('project_status', 4)
                        ->get()->count();

            $n5 = Project::where('project_status', 1)
                        ->get()->count();
        }
        else if (Auth::user()->access === 3) {
            $n1 = Project::withCount('features')
                        ->where('payment_status', 1)
                        ->where('project_status', 2)
                        ->where('user_id', Auth::id())
                        ->get()->count();

            $n2 = Project::with('cost')->where('payment_status', 2)
                        ->where('project_status', 2)
                        ->where('user_id', Auth::id())
                        ->get()->count();

            $n3 = Project::where('project_status', 3)
                        ->where('user_id', Auth::id())
                        ->get()->count();

            $n4 = Project::where('project_status', 4)
                        ->where('user_id', Auth::id())
                        ->get()->count();

            $n5 = Project::where('project_status', 1)
                        ->where('user_id', Auth::id())
                        ->get()->count();            
        }

        $projectCountBadge = [0,0,0,0,0];

        View::share('projectCountBadge', $projectCountBadge);

        return $next($request);
    }
}
