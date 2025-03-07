<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\WarrantyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::apiResource('/warranty', WarrantyController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy']);

        Route::apiResource('/invoice', InvoiceController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy']);
    });
