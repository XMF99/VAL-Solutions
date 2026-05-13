<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\PlanFeature;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index()
    {
        $pageTitle = 'إدارة المميزات والباقات';

        $plans = SubscriptionPlan::where('status', 1)->orderBy('monthly_price')->get();
        $features = Feature::where('status', 1)->orderBy('category')->orderBy('sort_order')->get();
        $categories = Feature::getCategories();

        $matrix = [];
        $planFeatures = PlanFeature::all();
        foreach ($planFeatures as $pf) {
            $matrix[$pf->feature_id][$pf->plan_id] = $pf->is_enabled;
        }

        return view('admin.features.index', compact('pageTitle', 'plans', 'features', 'categories', 'matrix'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'feature_id' => 'required|exists:features,id',
            'plan_id'    => 'required|exists:subscription_plans,id',
            'is_enabled' => 'required|boolean',
        ]);

        PlanFeature::updateOrCreate(
            ['plan_id' => $request->plan_id, 'feature_id' => $request->feature_id],
            ['is_enabled' => $request->is_enabled]
        );

        cache()->forget("user_features_{$request->plan_id}");

        return response()->json(['success' => true, 'message' => 'تمّ التحديث']);
    }
}
