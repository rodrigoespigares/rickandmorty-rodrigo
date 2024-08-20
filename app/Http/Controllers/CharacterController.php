<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class CharacterController extends Controller
{
    public function index(Request $request) {
        
        $page = $request->query('page', 1);
        $name = $request->query('name', "");
        $species = $request->query('species', "");
        $gender = $request->query('gender', "");
        $type = $request->query('type', "");

        $params = [];
        $page? $params['page'] = $page : null;
        $name? $params['name'] = $name : null;
        $species? $params['species'] = $species : null;
        $gender? $params['gender'] = $gender : null;
        $type? $params['type'] = $type : null;

        $characters = (new \App\Services\RickAndMortyService)->getCharacters($params);

        if(!isset($characters['info'])){
            return response()->json(['error' => true, "message" => "No characters found"], 404);
        }
        $characters['info']['next'] = $page + 1 >= $characters['info']['pages'] ? null : URL::route('characters.index', ['page' => $page + 1]);
        $characters['info']['prev'] = $page - 1 <= 0 ? null : URL::route('characters.index', ['page' => $page - 1]);

        return response()->json($characters, 200);
    }

    public function show($id) {
        $character = (new \App\Services\RickAndMortyService)->getCharacterById($id);
        if(!$character){
            return response()->json(['error' => true, "message" => "Character not found"], 404);
        }
        return response()->json($character, 200);
    }
}
