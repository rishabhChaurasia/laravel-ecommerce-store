<?php

namespace App\Console\Commands;

use App\Jobs\ProcessAbandonedCartJob;
use Illuminate\Console\Command;

class ProcessAbandonedCarts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-abandoned-carts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process abandoned carts and send reminder notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting abandoned cart processing...');

        // Dispatch the job to process abandoned carts
        ProcessAbandonedCartJob::dispatch();

        $this->info('Abandoned cart processing job dispatched.');
    }
}
