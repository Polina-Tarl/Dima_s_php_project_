<?php

use App\Http\Controllers\CatalogController;
use Illuminate\Support\Facades\Route;

Route::get('/test', fn() => view('test'));

Route::get('/', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/group/{id}', [CatalogController::class, 'group'])->name('catalog.group');
Route::get('/product/{id}', [CatalogController::class, 'show'])->name('catalog.product');
