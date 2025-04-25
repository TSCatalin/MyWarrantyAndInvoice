<?php

namespace App\Http\Controllers;

use App\Models\ActionHistory;
use App\Http\Requests\StoreActionHistoryRequest;
use App\Http\Requests\UpdateActionHistoryRequest;
use App\Http\Resources\ActionHistoryResource;
use Illuminate\Support\Facades\Auth;

class ActionHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $action_historyQuery = ActionHistory::where('user_id', $userId);

        $action_history = $action_historyQuery->get()->sortByDesc("created_at");

        return response()->json([
            'data' => ActionHistoryResource::collection($action_history),
        ]);
    }
}
