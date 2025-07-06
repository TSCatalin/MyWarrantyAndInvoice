<?php

namespace App\Http\Controllers;

use App\Models\Warranty;
use App\Http\Requests\StoreWarrantyRequest;
use App\Http\Requests\UpdateWarrantyRequest;
use App\Http\Resources\WarrantyResource;
use App\Jobs\UpdateWarrantyStatus;
use App\Models\ActionHistory;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class WarrantyController extends Controller
{
    use Notifiable;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $warrantiesQuery = Warranty::where('user_id', $userId);

        if ($request->query('seller')) {
            $warrantiesQuery->where('seller', $request->query('seller'));
        }

        if ($request->query('status') !== null) {
            $warrantiesQuery->where('status', $request->query('status'));
        }

        if ($request->query('product_name')) {
            $warrantiesQuery->where('product_name',  "like", "%" . $request->query('product_name') . "%");
        }

        if ($request->query('sortBy')) {
            switch ($request->query('sortBy')) {
                case 'purchase_DESC':
                    $warrantiesQuery->orderByDesc("date_purchase");
                    break;
                case 'purchase_ASC':
                    $warrantiesQuery->orderBy("date_purchase");
                    break;
                case 'warranty_end_DESC':
                    $warrantiesQuery->orderByDesc("warranty_end_date");
                    break;
                case 'warranty_end_ASC':
                    $warrantiesQuery->orderBy("warranty_end_date");
                    break;
                default:
                    $warrantiesQuery->orderByDesc("created_at");
            }
        } else {
            $warrantiesQuery->orderByDesc("created_at");
        }

        $warranties = $warrantiesQuery->paginate(9);

        $meta = [
            'current_page' => $warranties->currentPage(),
            'last_page' => $warranties->lastPage(),
            'per_page' => $warranties->perPage(),
            'total' => $warranties->total(),
            'from' => $warranties->firstItem(),
            'to' => $warranties->lastItem(),
        ];

        $sellers = Warranty::distinct()->pluck(column: 'seller');
        $status = Warranty::distinct()->pluck('status');

        return response()->json([
            'data' => WarrantyResource::collection($warranties),
            'seller' => $sellers,
            'status' => $status,
            'meta' => $meta
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWarrantyRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['seller'] = strtoupper($data['seller']);

        $warrantyEndDate = strtotime($data['warranty_end_date']);
        $currentDate = strtotime('today');
        
        if ($warrantyEndDate > $currentDate) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }

        $file = $request->file('warranty_file');

        $fileContent = file_get_contents($file->getRealPath());

        $data['warranty_file'] = $fileContent;

        Warranty::create($data);

        ActionHistory::create([
            "type_action" => 'CREATE',
            "info_action" => 'Warranty #' . $data['warranty_id'] . ' has been added.',
            "date_action" => now()->toDateTimeString(),
            "user_id" => Auth::id(),
        ]);

        return response()->json(null, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Warranty $warranty)
    {
        if (!$warranty) {
            return response()->json(['message' => 'Warranty not found'], 404);
        }
        return new WarrantyResource($warranty);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWarrantyRequest $request, Warranty $warranty)
    {
        $data = $request->validated();
        $file = $data['warranty_file'] ?? null;
        $data['seller'] = strtoupper($data['seller']);
        $warrantyEndDate = strtotime($data['warranty_end_date']);
        $currentDate = strtotime('today');
        if ($warrantyEndDate > $currentDate) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }

        if ($file) {
            $file = $request->file('warranty_file');
            $fileContent = file_get_contents($file->getRealPath());

            $data['warranty_file'] = $fileContent;
        }
        $warranty->update($data);

        ActionHistory::create([
            "type_action" => 'EDIT',
            "info_action" => 'Warranty #' . $warranty->warranty_id . ' has been modified.',
            "date_action" => now()->toDateTimeString(),
            "user_id" => Auth::id(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warranty $warranty)
    {
        $warranty_id = $warranty->warranty_id;

        $warranty->delete();

        ActionHistory::create([
            "type_action" => 'DELETE',
            "info_action" => 'Warranty #' . $warranty_id . ' has been deleted.',
            "date_action" => now()->toDateTimeString(),
            "user_id" => Auth::id(),
        ]);

        $userId = Auth::id();
        $user = User::find($userId);
        if ($user) {
            $user->notify(new UserNotification(
                'Warranty deleted',
                'Warranty #' . $warranty_id . ' has been deleted.',
                '/warranty'
            ));
        }

        return response(null, 204);
    }

    public function getWarrantyforInvoice(Request $request)
    {
        $userId = Auth::id();
        $warrantiesQuery = Warranty::where('user_id', $userId);

        if ($request->query('invoice_number')) {
            $warrantiesQuery->where('invoice_number', $request->query('invoice_number'));
        }

        $warrantiesVal = $warrantiesQuery->get();

        $warranties = $warrantiesVal->map(function ($warranty) {
            return [
                'id' => $warranty->id,
                'product_name' => $warranty->product_name,
                'warranty_id' => $warranty->warranty_id,
                'seller' => $warranty->seller,
                'customer_name' => $warranty->customer_name,
                'warranty_end_date' => $warranty->warranty_end_date,
            ];
        });

        return response()->json([
            'data' => $warranties,
        ]);
    }

    public function updateStatusWarranty()
    {
        $userId = Auth::id();
        UpdateWarrantyStatus::dispatch($userId);

        return response(null, 204);
    }

    public function dashboardWarranty()
    {
        $userId = Auth::id();
        $query = Warranty::where('user_id', $userId);
        $warrantiesCount = $query->count();
        $oneMonthAgo = now()->subMonth();
        $warrantiesCountLastMonth = $query->where('created_at', '>=', $oneMonthAgo)->count();
        $warranties = $query->orderByDesc("created_at")->take(3)->get();
        $warrantiesCountStatus1 = $query->where('status', 1)->count();
        $warrantiesCountStatus0 =  $warrantiesCount - $warrantiesCountStatus1;

        return response()->json([
            'warranties_count' => $warrantiesCount,
            'warrantiesCountLastMonth' => $warrantiesCountLastMonth,
            'warranties_count_status_1' => $warrantiesCountStatus1,
            'warranties_count_status_0' => $warrantiesCountStatus0,
            'warranties' => WarrantyResource::collection($warranties),
        ]);
    }
}
