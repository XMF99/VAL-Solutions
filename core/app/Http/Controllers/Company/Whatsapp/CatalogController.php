
<?php

namespace App\Http\Controllers\Company\Whatsapp;

use App\Models\Product;
use App\Models\WhatsappPublishedProduct;
use Illuminate\Http\Request;

class CatalogController extends BaseController
{
    /**
     * قائمة المنتجات (للنشر/الإخفاء)
     */
    public function index(Request $request)
    {
        $products = Product::where('company_id', $this->company->id)
            ->with('whatsappPublication')
            ->when($request->search, function ($q, $search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->when($request->filter === 'published', function ($q) {
                $q->whereHas('whatsappPublication', fn($q) => $q->where('is_published', true));
            })
            ->when($request->filter === 'unpublished', function ($q) {
                $q->whereDoesntHave('whatsappPublication')
                  ->orWhereHas('whatsappPublication', fn($q) => $q->where('is_published', false));
            })
            ->latest()
            ->paginate(24)
            ->withQueryString();

        $stats = [
            'total' => Product::where('company_id', $this->company->id)->count(),
            'published' => WhatsappPublishedProduct::where('company_id', $this->company->id)
                ->where('is_published', true)->count(),
            'pending_sync' => WhatsappPublishedProduct::where('company_id', $this->company->id)
                ->whereIn('sync_status', ['pending', 'failed'])->count(),
        ];

        return view('company.whatsapp.catalog.index', compact('products', 'stats'));
    }

    /**
     * نشر منتج
     */
    public function publish(Product $product)
    {
        $this->authorizeProduct($product);

        $publication = WhatsappPublishedProduct::updateOrCreate(
            [
                'company_id' => $this->company->id,
                'product_id' => $product->id,
            ],
            [
                'whatsapp_setting_id' => $this->setting->id,
                'is_published' => true,
                'sync_status' => 'pending',
            ]
        );

        return back()->with('success', 'تمّ نشر المنتج — ستتمّ المزامنة مع Meta قريباً');
    }

    /**
     * إخفاء منتج
     */
    public function unpublish(Product $product)
    {
        $this->authorizeProduct($product);

        if ($product->whatsappPublication) {
            $product->whatsappPublication->update([
                'is_published' => false,
                'sync_status' => 'unpublished',
            ]);
        }

        return back()->with('success', 'تمّ إخفاء المنتج من الواتساب');
    }

    /**
     * Toggle (للزرّ السريع في القائمة)
     */
    public function toggle(Product $product)
    {
        $this->authorizeProduct($product);

        $publication = $product->whatsappPublication;

        if (!$publication) {
            return $this->publish($product);
        }

        $publication->update([
            'is_published' => !$publication->is_published,
            'sync_status' => $publication->is_published ? 'unpublished' : 'pending',
        ]);

        return response()->json([
            'success' => true,
            'is_published' => $publication->is_published,
            'message' => $publication->is_published ? 'منشور' : 'مخفي',
        ]);
    }

    /**
     * تخصيص منتج (سعر/اسم/صورة بديلة للواتساب)
     */
    public function customize(Request $request, Product $product)
    {
        $this->authorizeProduct($product);

        $validated = $request->validate([
            'whatsapp_name' => 'nullable|string|max:255',
            'whatsapp_description' => 'nullable|string|max:9999',
            'whatsapp_price' => 'nullable|numeric|min:0',
            'whatsapp_sale_price' => 'nullable|numeric|min:0',
            'whatsapp_image_url' => 'nullable|url',
            'min_qty' => 'nullable|integer|min:1',
            'max_qty' => 'nullable|integer|min:1',
            'is_featured' => 'boolean',
            'display_order' => 'nullable|integer',
        ]);

        $publication = WhatsappPublishedProduct::updateOrCreate(
            [
                'company_id' => $this->company->id,
                'product_id' => $product->id,
            ],
            array_merge($validated, [
                'whatsapp_setting_id' => $this->setting->id,
                'sync_status' => 'pending', // إعادة المزامنة بعد التعديل
            ])
        );

        return back()->with('success', 'تمّ حفظ التخصيص ✅');
    }

    /**
     * مزامنة كل المنتجات مع Meta Catalog
     */
    public function syncAll()
    {
        $count = WhatsappPublishedProduct::where('company_id', $this->company->id)
            ->where('is_published', true)
            ->update([
                'sync_status' => 'pending',
                'next_sync_at' => now(),
            ]);

        return back()->with('success', "تمّت إضافة {$count} منتج لطابور المزامنة — سيتمّ تحديثها خلال دقائق");
    }

    /**
     * نشر جماعي (Bulk Publish)
     */
    public function bulkPublish(Request $request)
    {
        $request->validate([
            'product_ids' => 'required|array|min:1',
            'product_ids.*' => 'integer|exists:products,id',
            'action' => 'required|in:publish,unpublish',
        ]);

        $products = Product::where('company_id', $this->company->id)
            ->whereIn('id', $request->product_ids)
            ->get();

        $count = 0;
        foreach ($products as $product) {
            if ($request->action === 'publish') {
                WhatsappPublishedProduct::updateOrCreate(
                    ['company_id' => $this->company->id, 'product_id' => $product->id],
                    [
                        'whatsapp_setting_id' => $this->setting->id,
                        'is_published' => true,
                        'sync_status' => 'pending',
                    ]
                );
            } else {
                $product->whatsappPublication?->update([
                    'is_published' => false,
                    'sync_status' => 'unpublished',
                ]);
            }
            $count++;
        }

        return back()->with('success', "تمّت معالجة {$count} منتج");
    }

    /**
     * التأكّد إنّ المنتج يخصّ هذا التاجر
     */
    protected function authorizeProduct(Product $product): void
    {
        if ($product->company_id !== $this->company->id) {
            abort(403, 'هذا المنتج لا يخصّك');
        }
    }
}

