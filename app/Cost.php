<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Weight;

class Cost extends Model
{
    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function incomes()
    {
        return $this->hasMany('App\Income');
    }

    public function weight()
    {
        return $this->belongsTo('App\Weight');
    }

    public static function generateCost($criterion, $features)
    {
        $weight = Weight::latest()->first();
        $base = ([$weight->base_small, $weight->base_medium, $weight->base_big, ])[$criterion->instance_level - 1];

        $criteria_calc = $base * (($weight->complexity_weight * $criterion->complexity_level) / 100);
        $feature_calc = 0;
        $alternate_feature_calc = 0;

        $features = collect($features);
        if (count($features) > 0) {
            $feature_calc = $features->reduce(function($carry, $item) use ($base, $weight) {
                return $carry + ($base * $weight->features_weight / 100);
            });

            $alternate_feature_calc = $features->reduce(function($carry, $item) use ($base, $weight) {
                $calc = $item->priority < 3 ? ($base * $weight->features_weight / 100) : 0;
                return $carry + $calc;
            });
        }

        $calculationResult = $base + $criteria_calc + $feature_calc;
        $alternateCalculation = $base + $criteria_calc + $alternate_feature_calc;

        $cost = new Cost();
        $cost->project_id = $criterion->project_id;
        $cost->weight_id = $weight->id;
        $cost->calculation_result = $calculationResult;
        $cost->alternate_cost = $alternateCalculation;

        $cost->save();

        return $cost;
    } 
}
