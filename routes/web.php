<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocsSearchController;
use App\Models\DocAnalytics;
use App\Models\DocSearchHistory;

Route::redirect('/', '/docs');

Route::post('/docs/search-log', [DocsSearchController::class, 'store']);

Route::get('/docs-dashboard', function () {

    return view('docs.dashboard', [
        'data' => DocAnalytics::orderByDesc('views')->get(),
        'searches' => DocSearchHistory::orderByDesc('created_at')->limit(20)->get()
    ]);

});