<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Warranty;
use App\Notifications\UserNotification;
use Illuminate\Console\Command;

class NotifyExpiringWarranties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:expiring-warranties';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications for warranties that expire in the next 7 days.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $warranties = Warranty::whereDate('warranty_end_date', '<=', now()->addDays(7))
            ->whereDate('warranty_end_date', '>=', now())
            ->get();

        foreach ($warranties as $warranty) {
            $user = User::find($warranty->user_id);
            if ($user) {
                $user->notify(new UserNotification(
                    'Warranty Expiring Soon',
                    'The product warranty ' . $warranty->product_name . ' expires on.',
                    '/warranty'
                ));
            }
        }
        $this->info('The notifications have been sent');
    }
}
