<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\PlanFeature;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
<<<<<<< HEAD
    /**
     * صفحة إدارة المميزات والباقات (Matrix View)
     */
=======
>>>>>>> 5421e9124867a7797571dc26b266ddf4ed297deb
    public function index()
    {
        $pageTitle = 'إدارة المميزات والباقات';

        $plans = SubscriptionPlan::where('status', 1)->orderBy('monthly_price')->get();
        $features = Feature::where('status', 1)->orderBy('category')->orderBy('sort_order')->get();
        $categories = Feature::getCategories();

<<<<<<< HEAD
        // نبني الـmatrix: feature_id => [plan_id => is_enabled]
=======
>>>>>>> 5421e9124867a7797571dc26b266ddf4ed297deb
        $matrix = [];
        $planFeatures = PlanFeature::all();
        foreach ($planFeatures as $pf) {
            $matrix[$pf->feature_id][$pf->plan_id] = $pf->is_enabled;
        }

        return view('admin.features.index', compact('pageTitle', 'plans', 'features', 'categories', 'matrix'));
    }

<<<<<<< HEAD
    /**
     * تحديث ميزة في باقة (toggle on/off)
     */
=======
>>>>>>> 5421e9124867a7797571dc26b266ddf4ed297deb
    public function toggle(Request $request)
    {
        $request->validate([
            'feature_id' => 'required|exists:features,id',
            'plan_id'    => 'required|exists:subscription_plans,id',
            'is_enabled' => 'required|boolean',
        ]);

        PlanFeature::updateOrCreate(
<<<<<<< HEAD
            [
                'plan_id'    => $request->plan_id,
                'feature_id' => $request->feature_id,
            ],
            [
                'is_enabled' => $request->is_enabled,
            ]
        );

        // امسح cache هذي الباقة
        cache()->forget("user_features_{$request->plan_id}");

        return response()->json([
            'success' => true,
            'message' => 'تمّ التحديث',
        ]);
    }

    /**
     * تفعيل/إلغاء كل المميزات في فئة لباقة معيّنة
     */
    public function toggleCategory(Request $request)
    {
        $request->validate([
            'category'   => 'required|string',
            'plan_id'    => 'required|exists:subscription_plans,id',
            'is_enabled' => 'required|boolean',
        ]);

        $featureIds = Feature::where('category', $request->category)
            ->pluck('id')
            ->toArray();

        foreach ($featureIds as $featureId) {
            PlanFeature::updateOrCreate(
                ['plan_id' => $request->plan_id, 'feature_id' => $featureId],
                ['is_enabled' => $request->is_enabled]
            );
        }

        cache()->forget("user_features_{$request->plan_id}");

        return response()->json([
            'success' => true,
            'message' => 'تمّ التحديث للفئة كاملة',
        ]);
    }

    /**
     * عرض ملخّص: عدد المميزات لكل باقة
     */
    public function summary()
    {
        $plans = SubscriptionPlan::withCount(['planFeatures as features_count' => function ($q) {
            $q->where('is_enabled', true);
        }])->get();

        return response()->json($plans);
=======
            ['plan_id' => $request->plan_id, 'feature_id' => $request->feature_id],
            ['is_enabled' => $request->is_enabled]
        );

        cache()->forget("user_features_{$request->plan_id}");

        return response()->json(['success' => true, 'message' => 'تمّ التحديث']);
>>>>>>> 5421e9124867a7797571dc26b266ddf4ed297deb
    }
}
