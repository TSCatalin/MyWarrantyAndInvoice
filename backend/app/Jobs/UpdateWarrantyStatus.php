<?php

namespace App\Jobs;

use App\Models\Warranty;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Carbon\Carbon;

class UpdateWarrantyStatus implements ShouldQueue
{
    use Queueable;

    protected  $userId;
    /**
     * Create a new job instance.
     */
    public function __construct($userId)
    {
        $this->userId  =  $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $currentDate = Carbon::now(); // Data curentă

        Warranty::where('user_id', $this->userId)
            ->where('warranty_end_date', '<', $currentDate)
            ->where('status', '!=', 0)
            ->update(['status' => 0]);
    }
}
