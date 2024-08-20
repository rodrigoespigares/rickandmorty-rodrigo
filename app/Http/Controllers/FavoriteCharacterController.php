<?php

namespace App\Http\Controllers;

use App\Models\FavoriteCharacter;
use App\Services\RickAndMortyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteCharacterController extends Controller
{
    public function store(Request $request) {
        $request->validate(['character_id' => 'required|integer']);
        
        $character = (new RickAndMortyService)->getCharacterById($request->character_id);
        
        if (!$character) {
            return response()->json(['message' => 'Character not found'], 404);
        }
    
        $favorite = $request->user()->favoriteCharacters()->create([
            'character_id' => $request->character_id,
        ]);
    
        return response()->json($favorite, 201);
    }
    
    public function index(Request $request) {
        return response()->json($request->user()->favoriteCharacters()->with('details')->get());
    }
    
    public function destroy($id) {
        $favorite = FavoriteCharacter::where('user_id', Auth::user()->id)->where('character_id', $id)->first();
    
        if (!$favorite) {
            return response()->json(['message' => 'Not found'], 404);
        }
    
        $favorite->delete();
        return response()->json(null, 204);
    }
}
