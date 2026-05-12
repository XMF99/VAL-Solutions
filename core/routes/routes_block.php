<?php

// ════════════════════════════════════════════════════════════════
// إضافة في: core/routes/user.php
// ════════════════════════════════════════════════════════════════
// 
// أضف هذا البلوك داخل الـRoute::group اللي يبدأ بـ:
//   Route::group(['prefix' => 'user'], function () {
// 
// نضيفه قبل أيّ Route آخر فيه middleware('auth') أو في نفس المجموعة
// ════════════════════════════════════════════════════════════════

// ───── إشعارات دائنة (Credit Notes) ─────
Route::controller('CreditNoteController')->prefix('credit-note')->name('credit-note.')->group(function () {
    Route::get('/', 'list')->name('list');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/show/{id}', 'show')->name('show');
    Route::post('/cancel/{id}', 'cancel')->name('cancel');
    Route::post('/apply/{id}', 'apply')->name('apply');
});

// ════════════════════════════════════════════════════════════════
// الـRoutes النهائيّة (للاستخدام في الـviews):
//   user.credit-note.list      → GET  /user/credit-note
//   user.credit-note.create    → GET  /user/credit-note/create
//   user.credit-note.store     → POST /user/credit-note/store
//   user.credit-note.show      → GET  /user/credit-note/show/{id}
//   user.credit-note.cancel    → POST /user/credit-note/cancel/{id}
//   user.credit-note.apply     → POST /user/credit-note/apply/{id}
// ════════════════════════════════════════════════════════════════
