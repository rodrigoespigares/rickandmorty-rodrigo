<?php

namespace App\Http\Controllers;

use App\Models\FavoriteCharacter;
use App\Services\RickAndMortyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class FavoriteCharacterController extends Controller
{
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
    
    public function index(Request $request) {
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
    
    public function destroy($id) {
        $favorite = FavoriteCharacter::where('user_id', Auth::user()->id)->where('character_id', $id)->first();
    
        if (!$favorite) {
            return response()->json(['error' => true, 'message' => 'Not found'], 404);
        }
    
        $favorite->delete();
        return response()->json(['error' => false, 'message' => 'Character removed from favorites'], 202);
    }
}
