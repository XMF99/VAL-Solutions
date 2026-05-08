<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Company\Whatsapp\DashboardController;
use App\Http\Controllers\Company\Whatsapp\SettingsController;
use App\Http\Controllers\Company\Whatsapp\OrdersController;
use App\Http\Controllers\Company\Whatsapp\CatalogController;
use App\Http\Controllers\Company\Whatsapp\ConnectController;
use App\Http\Controllers\Webhook\WhatsappWebhookController;
use App\Http\Controllers\Storefront\PublicStoreController;

/*
|--------------------------------------------------------------------------
| WhatsApp Store Module Routes
|--------------------------------------------------------------------------
| 
| المسار: core/routes/whatsapp.php
| يُسجّل في core/routes/web.php بسطر واحد:
|   Route::middleware(['web'])->group(base_path('core/routes/whatsapp.php'));
|
*/


/*
|--------------------------------------------------------------------------
| 1. Merchant Dashboard (لوحة التاجر داخل OvoSale)
|--------------------------------------------------------------------------
| Prefix: /company/whatsapp
| Auth: company auth middleware
| Plan Check: subscription plan = 3 (Premium)
*/

Route::middleware(['auth.company'])
    ->prefix('company/whatsapp')
    ->name('company.whatsapp.')
    ->group(function () {

        // النظرة العامّة (Dashboard)
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/stats/realtime', [DashboardController::class, 'realtimeStats'])
            ->name('stats.realtime');

        // ─── الإعدادات ─────────────────────────────────────────
        Route::get('/settings', [SettingsController::class, 'edit'])
            ->name('settings.edit');

        Route::post('/settings', [SettingsController::class, 'update'])
            ->name('settings.update');

        Route::post('/settings/test-message', [SettingsController::class, 'sendTestMessage'])
            ->name('settings.test');

        // ─── ربط حساب الواتساب (Meta Onboarding) ──────────────
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

        // ─── الطلبات (WhatsApp Orders) ────────────────────────
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

        // ─── الكاتالوج (المنتجات المنشورة) ────────────────────
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
| Prefix: /store/{slug}
| Public — no auth required
*/

Route::prefix('store')
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
| 3. Meta Cloud API Webhook
|--------------------------------------------------------------------------
| URL: /webhook/whatsapp
| Public — Meta sends here, we verify with token
| ⚠️ مهمّ: مستثنى من CSRF (يُضاف لاحقاً في bootstrap/app.php)
*/

Route::prefix('webhook/whatsapp')
    ->name('webhook.whatsapp.')
    ->group(function () {
        // GET للتحقّق من Meta عند الإعداد
        Route::get('/', [WhatsappWebhookController::class, 'verify'])
            ->name('verify');

        // POST لاستلام الرسائل والأحداث
        Route::post('/', [WhatsappWebhookController::class, 'handle'])
            ->name('handle');
    });


/*
|--------------------------------------------------------------------------
| 4. Moyasar Payment Webhook
|--------------------------------------------------------------------------
| URL: /webhook/moyasar
| Public — Moyasar sends payment events here
*/

Route::prefix('webhook/moyasar')
    ->name('webhook.moyasar.')
    ->group(function () {
        Route::post('/', [\App\Http\Controllers\Webhook\MoyasarWebhookController::class, 'handle'])
            ->name('handle');
    });
