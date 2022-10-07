<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiServices
{

    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    function ditBonjour(): void
    {
        dump("Salut");
        $reponse = $this->client->request(
            'GET',
            'http://pokeapi.co/api/v2/pokemon/pikachu'
        );
        dump($reponse->toArray());
    }

    function ditAuRevoir(){
        dump("Au revoir");
    }
}