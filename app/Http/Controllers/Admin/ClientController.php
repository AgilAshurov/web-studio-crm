<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ClientService;
use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    protected ClientService $service;

    public function __construct(ClientService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        $client=$this->service->create($request->all());
        return $client;//redirect()->route('admin.clients.index');
    }

    public function update(Request $request, Client $client)
    {
        $this->service->update($client, $request->all());
        return redirect()->route('admin.clients.index');
    }

    public function destroy(Client $client)
    {
        $this->service->delete($client);
        return redirect()->route('admin.clients.index');
    }
}
