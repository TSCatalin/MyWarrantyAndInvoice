<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Resources\InvoiceResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $invoicesQuery = Invoice::where('user_id', $userId); // Creezi o instanță de query builder

        if ($request->query('seller')) {
            $invoicesQuery->where('seller', $request->query('seller'));
        }

        if ($request->query('product_name')) {
            $invoicesQuery->where('products_name',  "like", "%" . $request->query('product_name'). "%");
        }

        $invoices = $invoicesQuery->get()->sortByDesc("created_at");

        $sellers = Invoice::distinct()->pluck(column: 'seller');

        return response()->json([
            'data' => InvoiceResource::collection($invoices),
            'seller' => $sellers,
        ]);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['seller'] = strtoupper($data['seller']);

        $file = $request->file('invoice_file');

        $fileContent = file_get_contents($file->getRealPath());

        $data['invoice_file'] = $fileContent;

        Invoice::create($data);

        return response()->json(null, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }
        return new InvoiceResource($invoice);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        $data = $request->validated();
        $file = $data['invoice_file'] ?? null;
        $data['seller'] = strtoupper($data['seller']);

        if ($file) {
            $file = $request->file('invoice_file');

            $fileContent = file_get_contents($file->getRealPath());

            $data['invoice_file'] = $fileContent;
        }
        $invoice->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return response(null, 204);
    }
}
