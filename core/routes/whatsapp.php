<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Whatsapp\DashboardController;
use App\Http\Controllers\User\Whatsapp\SettingsController;
use App\Http\Controllers\User\Whatsapp\OrdersController;
use App\Http\Controllers\User\Whatsapp\CatalogController;
use App\Http\Controllers\User\Whatsapp\ConnectController;
use App\Http\Controllers\Storefront\PublicStoreController;

/*
|--------------------------------------------------------------------------
| WhatsApp Store Module Routes (V2 - User namespace)
|--------------------------------------------------------------------------
| 
| المسار: core/routes/whatsapp.php
| 
| ⚠️ ملاحظة:
| Webhook controllers (Meta + Moyasar) ستُضاف في Phase 4
| الآن نركّز على لوحة التاجر + الـ Storefront
|
*/


/*
|--------------------------------------------------------------------------
| 1. لوحة التاجر داخل OvoSale
|--------------------------------------------------------------------------
| URL Prefix:  /user/whatsapp
| Auth:        Laravel auth + check.status + has.subscription
| Plan check:  داخل BaseController (يفحص plan_id >= 3)
|
| ملاحظة: هذي routes تُحمّل عبر web.php فقط — بدون prefix إضافي
| لذا نضيف /user يدوياً هنا (مطابق لـ user.php)
*/

Route::middleware(['web', 'auth', 'check.status', 'registration.complete'])
    ->prefix('user/whatsapp')
    ->name('user.whatsapp.')
    ->group(function () {

        // ─── Dashboard ────────────────────────────────────────
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/stats/realtime', [DashboardController::class, 'realtimeStats'])
            ->name('stats.realtime');

        // ─── Settings ─────────────────────────────────────────
        Route::get('/settings', [SettingsController::class, 'edit'])
            ->name('settings.edit');

        Route::post('/settings', [SettingsController::class, 'update'])
            ->name('settings.update');

        Route::post('/settings/test-message', [SettingsController::class, 'sendTestMessage'])
            ->name('settings.test');

        // ─── Connect (ربط Meta) ───────────────────────────────
        Route::get('/connect', [ConnectController::class, 'show'])
            ->name('connect.show');

        Route::post('/connect/embedded-signup', [ConnectController::class, 'handleEmbeddedSignup'])
            ->name('connect.embedded');

        Route::post('/connect/manual', [ConnectController::class, 'handleManualConnect'])
            ->name('connect.manual');

        Route::post('/connect/verify-token', [ConnectController::class, 'verifyToken'])
            ->name('connect.verify');

        Route::post('/disconnect', [ConnectController::class, 'disconnect'])
            ->name('disconnect');

        // ─── Orders ───────────────────────────────────────────
        Route::get('/orders', [OrdersController::class, 'index'])
            ->name('orders.index');

        Route::get('/orders/{order}', [OrdersController::class, 'show'])
            ->name('orders.show');

        Route::post('/orders/{order}/confirm', [OrdersController::class, 'confirm'])
            ->name('orders.confirm');

        Route::post('/orders/{order}/status', [OrdersController::class, 'updateStatus'])
            ->name('orders.status');

        Route::post('/orders/{order}/convert-to-pos', [OrdersController::class, 'convertToPOS'])
            ->name('orders.convert');

        Route::post('/orders/{order}/cancel', [OrdersController::class, 'cancel'])
            ->name('orders.cancel');

        Route::post('/orders/{order}/send-message', [OrdersController::class, 'sendMessage'])
            ->name('orders.message');

        // ─── Catalog ──────────────────────────────────────────
        Route::get('/catalog', [CatalogController::class, 'index'])
            ->name('catalog.index');

        Route::post('/catalog/products/{product}/publish', [CatalogController::class, 'publish'])
            ->name('catalog.publish');

        Route::post('/catalog/products/{product}/unpublish', [CatalogController::class, 'unpublish'])
            ->name('catalog.unpublish');

        Route::post('/catalog/products/{product}/toggle', [CatalogController::class, 'toggle'])
            ->name('catalog.toggle');

        Route::post('/catalog/products/{product}/customize', [CatalogController::class, 'customize'])
            ->name('catalog.customize');

        Route::post('/catalog/sync-all', [CatalogController::class, 'syncAll'])
            ->name('catalog.sync');

        Route::post('/catalog/bulk-publish', [CatalogController::class, 'bulkPublish'])
            ->name('catalog.bulk');
    });


/*
|--------------------------------------------------------------------------
| 2. Public Storefront (متجر التاجر العام)
|--------------------------------------------------------------------------
| URL Prefix:  /store/{slug}
| Public — no auth required
*/

Route::middleware(['web'])
    ->prefix('store')
    ->name('storefront.')
    ->group(function () {
        Route::get('/{slug}', [PublicStoreController::class, 'show'])
            ->name('show');

        Route::get('/{slug}/products', [PublicStoreController::class, 'products'])
            ->name('products');

        Route::post('/{slug}/checkout', [PublicStoreController::class, 'checkout'])
            ->name('checkout');
    });


/*
|--------------------------------------------------------------------------
| 3. Webhook Routes — معطّلة الآن
|--------------------------------------------------------------------------
| ستُفعّل في Phase 4 بعد كتابة:
| - WhatsappWebhookController (لـ Meta)
| - MoyasarWebhookController (للدفع)
*/

// Phase 4 - to be added later:
// 
// Route::middleware(['web'])->prefix('webhook/whatsapp')->name('webhook.whatsapp.')->group(function () {
//     Route::get('/', [WhatsappWebhookController::class, 'verify'])->name('verify');
//     Route::post('/', [WhatsappWebhookController::class, 'handle'])->name('handle');
// });
//
// Route::middleware(['web'])->prefix('webhook/moyasar')->name('webhook.moyasar.')->group(function () {
//     Route::post('/', [MoyasarWebhookController::class, 'handle'])->name('handle');
// });
