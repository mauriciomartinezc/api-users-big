<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Jobs\Client\SyncClientsJob;
use App\Models\Client;
use App\Models\SynchronizationParameter;
use App\Services\Conectados\ApiConectados;
use App\Traits\ConsumesExternalServices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class ClientSyncController extends Controller
{
    /**
     * @var Client
     */
    protected Client $client;

    /**
     * @var SynchronizationParameter
     */
    protected SynchronizationParameter $synchronizationParameter;

    /**
     * @var ApiConectados
     */
    protected ApiConectados $apiConectados;

    /**
     * @param Client $client
     * @param SynchronizationParameter $synchronizationParameter
     * @param ApiConectados $apiConectados
     */
    public function __construct(
        Client                   $client,
        SynchronizationParameter $synchronizationParameter,
        ApiConectados            $apiConectados
    )
    {
        $this->client = $client;
        $this->synchronizationParameter = $synchronizationParameter;
        $this->apiConectados = $apiConectados;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function syncPublic(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
    {
        SyncClientsJob::dispatch()->afterResponse();
        return redirect('/');
    }

    /**
     * @return true
     */
    public function sync(): bool
    {
        $parameterCreate = $this->synchronizationParameter
            ->getSyncParameter($this->client->getTable(), $this->client::SYNC_PARAMETER_COLUMN_CREATE, 'create');
        $parameterUpdate = $this->synchronizationParameter
            ->getSyncParameter($this->client->getTable(), $this->client::SYNC_PARAMETER_COLUMN_UPDATE, 'update');
        if (!$parameterCreate || !$parameterUpdate) {
            $parameters = $this->synchronizationParameter->creteOrUpdateSyncParameters($this->client, '0', 'create');
            $parameters = $this->synchronizationParameter->creteOrUpdateSyncParameters($this->client, '2020-01-01', 'update');
            $parameterCreate = $parameters['parameter_create'];
            $parameterUpdate = $parameters['parameter_update'];
        }
        $clients = $this->apiConectados->getClients();
        if ($clients) {
            if ($parameterCreate->value == '0') {
                $this->createClients($clients, true);
            } else {
                $this->filterClients($clients, $parameterCreate, $parameterUpdate);
            }
        }
        return true;
    }

    /**
     * @param array $clients
     * @param bool $firstLoad
     * @return void
     */
    private function createClients(array $clients, bool $firstLoad = false): void
    {
        foreach ($clients as $client) {
            $client['id_api'] = $client['id'];
            if (!$this->client->where('id_api', $client['id_api'])->exists()) {
                $this->client->create($client);
                $this->synchronizationParameter->creteOrUpdateSyncParameters($this->client, (string)$client['id'], 'create');
                if ($firstLoad) {
                    $this->synchronizationParameter->creteOrUpdateSyncParameters($this->client, (string)$client['updated_at'], 'update');
                }
            }
        }
    }

    /**
     * @param array $clients
     * @return void
     */
    private function updateClients(array $clients): void
    {
        foreach ($clients as $client) {
            $client['id_api'] = $client['id'];
            unset($client['id']);
            $this->client->where('id_api', $client['id_api'])
                ->update($client);
            $this->synchronizationParameter->creteOrUpdateSyncParameters($this->client, (string)$client['updated_at'], 'update');
        }
    }

    /**
     * @param array $clients
     * @param SynchronizationParameter $parameterCreate
     * @param SynchronizationParameter $parameterUpdate
     * @return void
     */
    private function filterClients(array $clients, SynchronizationParameter $parameterCreate, SynchronizationParameter $parameterUpdate): void
    {
        $updateClients = $clients;
        $createClients = $clients;
        $updateClients = array_filter($updateClients, function ($client) use ($parameterUpdate) {
            return ($client[$parameterUpdate->column] > $parameterUpdate->value);
        });
        $createClients = array_filter($createClients, function ($client) use ($parameterCreate) {
            return ($client[$parameterCreate->column] > $parameterCreate->value);
        });
        $this->createClients($createClients);
        $this->updateClients($updateClients);
    }
}
