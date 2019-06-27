<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Weight;

class WeightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $weights = Weight::orderBy('id', 'desc')->paginate(8);
        $latestWeight = Weight::latest()->first();

        return view('content.weight.index', [
            'weights' => $weights,
            'latestWeight' => $latestWeight,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $weight = new Weight();

        $weight->complexity_weight = $request->complexity_weight;
        $weight->features_weight = $request->features_weight;
        $weight->base_small = $request->base_small;
        $weight->base_medium = $request->base_medium;
        $weight->base_big = $request->base_big;
        $weight->user_id = Auth::id();

        $weight->save();

        return redirect()->route('bobot.index')->with('success', 'Berhasil memperbaharui bobot!');
    }
}
