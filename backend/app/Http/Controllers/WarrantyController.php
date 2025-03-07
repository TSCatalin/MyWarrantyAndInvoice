<?php

namespace App\Http\Controllers;

use App\Models\Warranty;
use App\Http\Requests\StoreWarrantyRequest;
use App\Http\Requests\UpdateWarrantyRequest;
use App\Http\Resources\WarrantyResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class WarrantyController extends Controller
{
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
            $warrantiesQuery->where('product_name',  "like", "%" . $request->query('product_name'). "%");
        }

        $warranties = $warrantiesQuery->get()->sortByDesc("created_at");

        $sellers = Warranty::distinct()->pluck(column: 'seller');
        $status = Warranty::distinct()->pluck('status');

        return response()->json([
            'data' => WarrantyResource::collection($warranties),
            'seller' => $sellers,
            'status' => $status
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
        ;
        if ($warrantyEndDate > $currentDate) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }

        $file = $request->file('warranty_file');

        $fileContent = file_get_contents($file->getRealPath());

        $data['warranty_file'] = $fileContent;

        Warranty::create($data);

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
        ;

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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warranty $warranty)
    {
        $warranty->delete();

        return response(null, 204);
    }
}
