<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Resources\InvoiceResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;
use App\Http\Requests\StoreActionHistoryRequest;
use App\Models\ActionHistory;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $invoicesQuery = Invoice::where('user_id', $userId);

        if ($request->query('seller')) {
            $invoicesQuery->where('seller', $request->query('seller'));
        }

        if ($request->query('product_name')) {
            $invoicesQuery->where('products_name',  "like", "%" . $request->query('product_name') . "%");
        }


        if ($request->query('sortBy')) {
            if ($request->query('sortBy') == "purchase_DESC") {
                $invoicesQuery->orderByDesc("date_purchase");
            } else {
                $invoicesQuery->orderBy("date_purchase");
            }
        } else {
            $invoicesQuery->orderByDesc("created_at");
        }
        $invoices = $invoicesQuery->paginate(8);

        $meta = [
            'current_page' => $invoices->currentPage(),
            'last_page' => $invoices->lastPage(),
            'per_page' => $invoices->perPage(),
            'total' => $invoices->total(),
            'from' => $invoices->firstItem(),
            'to' => $invoices->lastItem(),
        ];

        $sellers = Invoice::distinct()->pluck(column: 'seller');

        return response()->json([
            'data' => InvoiceResource::collection($invoices),
            'seller' => $sellers,
            'meta' => $meta
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

        ActionHistory::create([
            "type_action" => 'CREATE',
            "info_action" => 'Invoice #' . $data['invoice_number'] . ' has been added.',
            "date_action" => now()->toDateTimeString(),
            "user_id" => Auth::id(),
        ]);

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

        ActionHistory::create([
            "type_action" => 'EDIT',
            "info_action" => 'Invoice #' . $invoice->invoice_number . ' has been modified.',
            "date_action" => now()->toDateTimeString(),
            "user_id" => Auth::id(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice_number = $invoice->invoice_number;

        $invoice->delete();

        ActionHistory::create([
            "type_action" => 'DELETE',
            "info_action" => 'Invoice #' . $invoice_number . ' has been deleted.',
            "date_action" => now()->toDateTimeString(),
            "user_id" => Auth::id(),
        ]);

        return response(null, 204);
    }

    public function getInvoiceNumber()
    {
        $userId = Auth::id();
        $invoicesQuery = Invoice::where('user_id', $userId);
        $invoices = $invoicesQuery->get(['invoice_number'])->sortByDesc("created_at");
        $invoiceNumbers = $invoices->pluck('invoice_number');

        return response()->json([
            'data' => $invoiceNumbers,
        ]);
    }

    public function dashboardInvoice()
    {
        $userId = Auth::id();
        $query = Invoice::where('user_id', $userId);
        $invoicesCount = $query->count();
        $oneMonthAgo = now()->subMonth();
        $invoicesCountLastMonth = $query->where('created_at', '>=', $oneMonthAgo)->count();
        $invoices = $query->orderByDesc("created_at")->take(3)->get();

        $sumByCurrency = $query->selectRaw('currency, ROUND(SUM(value), 2) as total')
            ->groupBy('currency')
            ->get();

        return response()->json([
            'invoices_count' => $invoicesCount,
            'invoicesCountLastMonth' => $invoicesCountLastMonth,
            'invoices' => InvoiceResource::collection($invoices),
            'sum_by_currency' => $sumByCurrency,
        ]);
    }
}
