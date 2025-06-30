<?php

namespace Bits\MmShopBundle\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ClientService
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getClient(): HttpClientInterface
    {
        return $this->client;
    }

}
