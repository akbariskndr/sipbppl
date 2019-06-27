<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Project;
use App\Criterion;
use App\Feature;
use App\Cost;
use App\Income;
use Carbon\Carbon;

use PDF;

class ProjectController extends Controller
{
    public function notCalculated()
    {
        // kalau Admin, lihat semua projek
        if (Auth::user()->access === 1) {
            // projek yang belum dihitung, payment_statusnya bernilai 1 (belum dihitung) dan project_statusnya bernilai 2 (pending)
            $notCalculatedProjects = Project::withCount('features')
                                            ->where('payment_status', 1)
                                            ->where('project_status', 2)
                                            ->get();
        }

        // kalau manajer cuma liat yang dia handle
        else {
            // projek yang belum dihitung, payment_statusnya bernilai 1 (belum dihitung) dan project_statusnya bernilai 2 (pending)
            $notCalculatedProjects = Project::withCount('features')
                                            ->where('payment_status', 1)
                                            ->where('project_status', 2)
                                            ->where('user_id', Auth::id())
                                            ->get();
        }

        return view('content.project.notcalculated', [
            'projects' => $notCalculatedProjects,
        ]);
    }

    public function notConfirmed()
    {
        // kalau Admin, lihat semua projek
        if (Auth::user()->access === 1) {
            // projek yang sudah dihitung, payment_statusnya bernilai 2 (belum dibayar) dan project_statusnya bernilai 2 (pending) 
            $calculatedProjects = Project::with('cost')->where('payment_status', 2)
                                            ->where('project_status', 2)
                                            ->get();
        }

        // kalau manajer cuma liat yang dia handle
        else {
            // projek yang sudah dihitung, payment_statusnya bernilai 2 (belum dibayar) dan project_statusnya bernilai 2 (pending) 
            $calculatedProjects = Project::with('cost')->where('payment_status', 2)
                                            ->where('project_status', 2)
                                            ->where('user_id', Auth::id())
                                            ->get();
        }

        return view('content.project.notconfirmed', [
            'projects' =>  $calculatedProjects,
        ]);
    }

    public function inProgress()
    {
        // kalau Admin, lihat semua projek
        if (Auth::user()->access === 1) {
            $inProgressProjects = Project::where('project_status', 3)
                                            ->get();
        }

        // kalau manajer cuma liat yang dia handle
        else {
            // projek yang sedang dikerjakan, project_statusnya bernilai 3 (sedang dikerjakan),
            // payment_statusnya bisa bernilai 2 (belum dibayar) atau 3 (dibayar sebagian)
            // tergantung dari nilai payment_type
            $inProgressProjects = Project::where('project_status', 3)
                                            ->where('user_id', Auth::id())
                                            ->get();
        }

        return view('content.project.inprogress', [
            'projects' => $inProgressProjects,
        ]);
    }

    public function completed()
    {
        // kalau Admin, lihat semua projek
        if (Auth::user()->access === 1) {
            $completedProjects = Project::where('project_status', 4)
                                            ->get();
        }

        // kalau manajer cuma liat yang dia handle
        else {
            // projek yang sudah selesai dikerjakan, project_statusnya bernilai 4 (selesai)
            // payment_status pasti bernilai 4
            $completedProjects = Project::where('project_status', 4)
                                            ->where('user_id', Auth::id())
                                            ->get();
        }

        return view('content.project.completed', [
            'projects' => $completedProjects,
        ]);
    }

    public function failed()
    {
        // kalau Admin, lihat semua projek
        if (Auth::user()->access === 1) {
            // projek yang gagal, nilai project_statusnya bernilai 1 (gagal)
            $failedProjects = Project::where('project_status', 1)
                                        ->get();
        }

        // kalau manajer cuma liat yang dia handle
        else {
            // projek yang gagal, nilai project_statusnya bernilai 1 (gagal)
            $failedProjects = Project::where('project_status', 1)
                                        ->where('user_id', Auth::id())
                                        ->get();
        }

        return view('content.project.failed', [
            'projects' => $failedProjects,
        ]);
    }

    public function history()
    {
        $projects = Project::paginate(15);

        return view('content.project.list', [
            'title' => 'Riwayat Proyek',
            'projects' => $projects,
        ]);
    }

    public function handled()
    {
        $projects = Project::where('user_id', Auth::id())
                                ->paginate(15);
        
        return view('content.project.list', [
            'title' => 'Proyek Yang Ditangani Oleh Anda',
            'projects' => $projects,
        ]);
    }

    public function calculate($id)
    {
        $project = Project::findOrFail($id);

        Cost::generateCost($project->criterion, $project->features);

        $project->payment_status = 2;
        $project->save();

        return redirect()->route('proyek.not_confirmed')->with('success', "Berhasil melakukan perhitungan!");
    }

    public function confirm(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $cost = Cost::where('project_id', $project->id)->first();
        
        $project->payment_status = 2;
        $project->project_status = 3;
        
        $cost->final_cost = $request->final_cost;

        if ($project->payment_type === 1) {
            $project->payment_status = 3;
            
            $cost->down_payment = $request->down_payment;

            $income = new Income();
            $income->cost_id = $cost->id;
            $income->quantity = intval($request->down_payment);
            $income->note = "Uang Muka dari Proyek $project->title";
            $income->income_date = Carbon::now();

            $income->save();
        }

        $project->save();
        $cost->save();

        return redirect()->route('proyek.in_progress')->with('success', "Berhasil melakukan konfirmasi!");
    }

    public function done($id)
    {
        $project = Project::findOrFail($id);
        $project->finish_date = Carbon::now();
        $project->payment_status = 4;
        $project->project_status = 4;
        $project->save();
        
        $cost = Cost::where('project_id', $project->id)->first();
        $income = new Income();
        
        $income->cost_id = $cost->id;
        $income->quantity = $project->payment_type === 1 ? ($cost->final_cost - $cost->down_payment) : $cost->final_cost;

        $income->note = "Pembayaran Akhir Proyek $project->title";
        $income->income_date = Carbon::now();

        $income->save();

        return redirect()->route('proyek.completed')->with('success', 'Berhasil menyelesaikan proyek!');
    }

    public function fail($id)
    {
        $project = Project::findOrFail($id);
        $project->project_status = 1;
        $project->payment_status = 1;

        $project->save();

        if ($project->payment_status === 2)
        {
            $cost = Cost::where('project_id', $project->id)->get();
            $cost->delete();
        }

        return redirect()->route('proyek.failed')->with('success', 'Berhasil membatalkan proyek!');
    }

    public function create()
    {
        return view('content.project.create');
    }

    public function store(Request $request)
    {
        $project = new Project();
        $project->title = $request->title;
        $project->instance_name = $request->instance_name;
        $project->client_name = $request->client_name;
        $project->client_phone = $request->client_phone;
        $project->client_email = $request->client_email;
        $project->payment_type = $request->payment_type;
        $project->project_status = 2;
        $project->payment_status = 1;
        $project->user_id = Auth::id();
        $project->start_date = Carbon::createFromFormat('d/m/Y', $request->start_date);

        $project->save();

        $criterion = new Criterion();
        $criterion->project_id = $project->id;
        $criterion->instance_level = $request->instance_level;
        $criterion->complexity_level = $request->complexity_level;
        $criterion->save();

        $features = [];
        if ($request->has('name')) {
            for ($i = 0; $i < count($request->name); $i++) {
                $feature = new Feature();
                $feature->name = $request->name[$i];
                $feature->priority = $request->priority[$i];
                $feature->project_id = $project->id;

                $feature->save();
                $features[] = $feature;
            }
        }


        if (intval($request->submit_option) === 1) {
            $project->payment_status = 2;
            $project->save();

            Cost::generateCost($criterion, $features);
        }

        return redirect()->route($project->payment_status === 2 ? 'proyek.not_confirmed' : 'proyek.not_calculated')->with('success', 'Berhasil menambahkan proyek!');

    }

    public function show($id)
    {
        $project = Project::with(['criterion', 'features', 'user'])->findOrFail($id);

        return view('content.project.show', ['project' => $project]);
    }

    public function print($id)
    {
        $project = Project::findOrFail($id);

        return view('pdf.project', ['project' => $project]);
    }

    public function edit($id)
    {
        $project = Project::with(['criterion', 'features'])->findOrFail($id);

        return view('content.project.edit', ['project' => $project]);
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $project->title = $request->title;
        $project->client_name = $request->client_name;
        $project->client_phone = $request->client_phone;
        $project->client_email = $request->client_email;
        $project->instance_name = $request->instance_name;

        $project->start_date = Carbon::createFromFormat('d/m/Y', $request->start_date);

        if ($project->project_status < 3) {
            $project->payment_type = $request->payment_type;
        }

        if ($project->payment_status === 1) {
            Criterion::where('project_id', $project->id)->delete();
            Feature::where('project_id', $project->id)->delete();

            $criterion = new Criterion();
            $criterion->instance_level = $request->instance_level;
            $criterion->complexity_level = $request->complexity_level;
            $criterion->project_id = $project->id;
            $criterion->save();

            if ($request->has('name')) {
                for ($i = 0; $i < count($request->name); $i++) {
                    $feature = new Feature();
                    $feature->name = $request->name[$i];
                    $feature->priority = $request->priority[$i];
                    $feature->project_id = $project->id;
    
                    $feature->save();
                }
            }
        }

        $project->save();

        return redirect()->route('proyek.show', $project->id)->with('success', 'Berhasil memperbaharui proyek!');
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        if ($project->project_status < 3) {
            
            if ($project->payment_status !== 1) {
                Criterion::where('project_id', $project->id)->delete();
                Feature::where('project_id', $project->id)->delete();
            }

            $project->delete();

            return redirect()->route('proyek.history')->with('success', 'Berhasil menghapus proyek!');
        }

        return back()->with('alert', 'Proyek tidak bisa dihapus!');
    }
}
