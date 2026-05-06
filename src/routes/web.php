<?php

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Illuminate\Support\Facades\Response;
use App\Http\Livewire\MapBranchViewer;
use App\Http\Livewire\QrScanner;
use App\Livewire\BorrowUnit;
use App\Models\Unit;


/* NOTE: Do Not Remove
/ Livewire asset handling if using sub folder in domain
*/

Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});
/*
/ END
*/
//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', function () {
    return view('customer-dashboard');
})->name('dashboard');

Route::get('/customer/dashboard', function () {
    return view('customer-dashboard');
});

Route::get('/borrow', BorrowUnit::class)->name('borrow');

Route::get('/units/{id}', function ($id) {
    $unit = Unit::findOrFail($id);
    return view('unit-detail', compact('unit'));
});
