<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;

class ClientIndexController extends Controller
{
    /**
     * @var Client
     */
    protected Client $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $clients = $this->client->latest('created_at')->paginate($this->client::DEFAULT_PAGINATE);
        return view('client.index', [
            'clients' => $clients
        ]);
    }
}
