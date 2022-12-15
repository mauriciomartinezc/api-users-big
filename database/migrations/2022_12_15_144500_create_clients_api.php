<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $clients = json_decode(file_get_contents(__DIR__ . '/clients.json'), true);
        foreach ($clients as $attributes) {
            $client = new \App\Models\Client();
            $client->create($client->setDataCreate($attributes));
        }
        $lastId = \App\Models\Client::latest('id')->first()->id_api;
        $lastUpdateAt = \App\Models\Client::latest('updated_at')->first()->updated_at;
        $synchronizationParameter = new \App\Models\SynchronizationParameter();
        $synchronizationParameter->creteOrUpdateSyncParameters(new \App\Models\Client(), (string)$lastId, 'create');
        $synchronizationParameter->creteOrUpdateSyncParameters(new \App\Models\Client(), (string)$lastUpdateAt, 'update');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
};
