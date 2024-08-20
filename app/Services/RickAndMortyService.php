<?php

namespace App\Services;


class RickAndMortyService {
    protected $client;

    public function __construct() {
        $this->client = new \GuzzleHttp\Client(['base_uri' => 'https://rickandmortyapi.com/api/']);
    }

    public function getCharacters($queryParams = []) {
        try {
            $response = $this->client->request('GET', 'character', ['query' => $queryParams]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function getCharacterById($id) {
        $response = $this->client->request('GET', "character/{$id}");
        return json_decode($response->getBody()->getContents(), true);
    }
}