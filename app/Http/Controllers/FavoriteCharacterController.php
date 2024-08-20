<?php

namespace App\Http\Controllers;

use App\Models\FavoriteCharacter;
use App\Services\RickAndMortyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class FavoriteCharacterController extends Controller
{
    /** 
     * Añadir un personaje a la lista de favoritos.
     *
     * @group Autenticado
     * 
     * @bodyParam character_id integer Id del personaje
     *
     * @response 201 {
     *    "error": false,
     *    "message": "Character added to favorites"
     * }
     * @response 404 {
     *    "error": true,
     *    "message": "Character not found"
     * }
     */
    public function store(Request $request) {
        $request->validate(['character_id' => 'required|integer']);
        
        $character = (new RickAndMortyService)->getCharacterById($request->character_id);
        
        if (!$character) {
            return response()->json(['message' => 'Character not found'], 404);
        }
    
        $favorite = FavoriteCharacter::create([ 
            'user_id' => Auth::user()->id,
            'character_id' => $request->character_id,
        ]);
    
        return response()->json(["error"=> false, "message"=> "Character added to favorites"], 201);
    }
    
    /**
     * Listar los personajes favoritos.
     *
     * @group Autenticado
     * 
     * @response 200 {[
     *    {
     *        "character_id": integer,
     *        "url": string
     *    }
     * ]}
     */
    public function index() {
        $characters = FavoriteCharacter::where('user_id', Auth::user()->id)->get();
        $baseUrl = rtrim(URL::to('/api/characters/'), '/') . '/';

        $charactersWithUrls = $characters->map(function ($character) use ($baseUrl) {
            return [
                'character_id' => $character->character_id,
                'url' => $baseUrl . $character->character_id
            ];
        });

        return response()->json($charactersWithUrls);
    }
    
    /**
     * Eliminar un personaje de la lista de favoritos.
     *
     * @group Autenticado
     * 
     * @queryParam id integer required Id del personaje
     * 
     * @response 202 {
     *    "error": false,
     *    "message": "Character removed from favorites"
     * }
     * @response 404 {
     *    "error": true,
     *    "message": "Not found"
     * }
     */
    public function destroy($id) {
        $favorite = FavoriteCharacter::where('user_id', Auth::user()->id)->where('character_id', $id)->first();
    
        if (!$favorite) {
            return response()->json(['error' => true, 'message' => 'Not found'], 404);
        }
    
        $favorite->delete();
        return response()->json(['error' => false, 'message' => 'Character removed from favorites'], 202);
    }
}
