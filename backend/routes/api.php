<?php

use App\Http\Controllers\ActionHistoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\WarrantyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::get('/warranty/get-warrantyforinvoice', [WarrantyController::class, 'getWarrantyforInvoice']);
        Route::get('warranty/updateStatusWarranty',[WarrantyController::class, 'updateStatusWarranty']);
        Route::get('warranty/dashboardWarranty', [WarrantyController::class,'dashboardWarranty']);

        Route::apiResource('/warranty', WarrantyController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy']);

        Route::get('/invoice/get-invoice-numbers', [InvoiceController::class, 'getInvoiceNumber']);
        Route::get('invoice/dashboardInvoice', [InvoiceController::class,'dashboardInvoice']);

        Route::apiResource('/invoice', InvoiceController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy']);


        Route::apiResource('/action_history', ActionHistoryController::class)
            ->only(['index', 'store'])->names([
                'store' => 'action_history.store',
                'index' => 'action_history.index',
            ]);
    });
