<?php

namespace App\Services\Conectados;

use App\Traits\ConsumesExternalServices;

class ApiConectados
{
    use ConsumesExternalServices;

    public function __construct()
    {
        $this->endPoint = config('app.endpoint_conectados_web');
        $this->apiToken = config('app.api_key_conectados_web');
    }

    /**
     * @return mixed|null
     */
    public function getClients(): mixed
    {
        return $this->performRequest(ApiConectados::class, 'getClients', 'GET', "$this->endPoint/users/$this->apiToken");
    }

    /**
     * @param int $clientId
     * @return mixed|null
     */
    public function getTransactionsForClient(int $clientId): mixed
    {
        return $this->performRequest(ApiConectados::class, 'getTransactionsForClient', 'GET', "$this->endPoint/users/$this->apiToken/transaction/$clientId");
    }
}
