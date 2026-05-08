
<?php

namespace App\Http\Controllers\Company\Whatsapp;

use App\Models\WhatsappOrder;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    /**
     * الصفحة الرئيسيّة للوحة الواتساب
     */
    public function index()
    {
        $stats = $this->whatsappService->getDashboardStats($this->company->id);

        $recentOrders = WhatsappOrder::where('company_id', $this->company->id)
            ->latest()
            ->take(10)
            ->get();

        return view('company.whatsapp.dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'isConnected' => $this->setting->isConnected(),
        ]);
    }

    /**
     * إحصائيّات لحظيّة (AJAX/Polling)
     */
    public function realtimeStats(Request $request)
    {
        return response()->json([
            'stats' => $this->whatsappService->getDashboardStats($this->company->id),
            'pending_count' => WhatsappOrder::where('company_id', $this->company->id)
                ->where('status', 'pending')->count(),
            'last_order' => WhatsappOrder::where('company_id', $this->company->id)
                ->latest()->first()?->only(['id', 'order_number', 'customer_name', 'total', 'created_at']),
            'updated_at' => now()->toIso8601String(),
        ]);
    }
}
