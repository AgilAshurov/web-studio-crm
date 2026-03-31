<?php

namespace App\Services;

use App\Models\Client;

class ClientService
{
    public function create(array $data): Client
    {
        return Client::create($data);
    }

    public function update(Client $client, array $data): Client
    {
        $client->update($data);
        return $client;
    }

    public function delete(Client $client): void
    {
        $client->delete();
    }

    public function list()
    {
        return Client::paginate(20);
    }
}

