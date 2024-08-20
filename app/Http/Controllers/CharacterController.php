<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CharacterController extends Controller
{
    public function index(Request $request) {
        
        $page = $request->query('page', 1);

        $characters = (new \App\Services\RickAndMortyService)->getCharacters(["page" => $page]);
        if(!$characters['results']){
            return response()->json(['error' => true, "message" => "No characters found"], 404);
        }
        return response()->json($characters['results'], 200);
    }
}
