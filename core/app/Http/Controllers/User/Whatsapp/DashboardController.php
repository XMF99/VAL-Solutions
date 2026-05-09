<?php

namespace App\Http\Controllers\User\Whatsapp;

use App\Models\WhatsappOrder;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    /**
     * الصفحة الرئيسيّة
     */
    public function index()
    {
        $stats = $this->whatsappService->getDashboardStats($this->merchant->id);

        $recentOrders = WhatsappOrder::where('user_id', $this->merchant->id)
            ->latest()
            ->take(10)
            ->get();

        return view('user.whatsapp.dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'isConnected' => $this->setting->isConnected(),
        ]);
    }

    /**
     * إحصائيّات لحظيّة (AJAX)
     */
    public function realtimeStats(Request $request)
    {
        return response()->json([
            'stats' => $this->whatsappService->getDashboardStats($this->merchant->id),
            'pending_count' => WhatsappOrder::where('user_id', $this->merchant->id)
                ->where('status', 'pending')->count(),
            'last_order' => WhatsappOrder::where('user_id', $this->merchant->id)
                ->latest()->first()?->only(['id', 'order_number', 'customer_name', 'total', 'created_at']),
            'updated_at' => now()->toIso8601String(),
        ]);
    }
}
