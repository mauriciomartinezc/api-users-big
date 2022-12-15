<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Transaction;
use App\Services\Conectados\ApiConectados;
use Illuminate\Http\Request;

class ClientShowController extends Controller
{
    /**
     * @var Transaction
     */
    protected Transaction $transaction;

    /**
     * @var ApiConectados
     */
    protected ApiConectados $apiConectados;

    /**
     * @param Transaction $transaction
     * @param ApiConectados $apiConectados
     */
    public function __construct(Transaction $transaction, ApiConectados $apiConectados)
    {
        $this->transaction = $transaction;
        $this->apiConectados = $apiConectados;
    }

    /**
     * @param Client $client
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Client $client): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $transactions = $this->apiConectados->getTransactionsForClient($client->id_api);
        if (is_array($transactions)) {
            $this->transaction->syncData($transactions);
        }
        $transactions = $this->transaction->where('client_id', $client->id_api)
            ->latest('created_at')
            ->paginate($this->transaction::DEFAULT_PAGINATE);
        return view('client.show', [
            'transactions' => $transactions
        ]);
    }
}
