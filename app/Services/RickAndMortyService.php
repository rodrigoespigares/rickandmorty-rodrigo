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
            return [];
        }
    }

    public function getCharacterById($id) {
        try{
            $response = $this->client->request('GET', "character/{$id}");
            return json_decode($response->getBody()->getContents(), true);
        }catch(\Exception $e){
            return [];
        }
    }
}