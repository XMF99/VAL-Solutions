<?php

use App\Http\Controllers\User\Whatsapp\UpgradePlanController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])
    ->prefix('user/whatsapp')
    ->name('user.whatsapp.')
    ->group(function () {
        Route::get('upgrade/{id}',         [UpgradePlanController::class, 'show'])->name('upgrade.show');
        Route::post('upgrade/{id}/process',[UpgradePlanController::class, 'process'])->name('upgrade.process');
    });
