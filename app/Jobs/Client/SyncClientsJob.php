<?php

namespace App\Jobs\Client;

use App\Http\Controllers\Client\ClientSyncController;
use App\Models\Client;
use App\Models\SynchronizationParameter;
use App\Services\Conectados\ApiConectados;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncClientsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $clientSyncApiController = new ClientSyncController(new Client(), new SynchronizationParameter(), new ApiConectados());
        $clientSyncApiController->sync();
    }
}
