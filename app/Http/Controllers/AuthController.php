<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request){
        try {
            // Validar los datos del request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);
    
            // Crear el usuario
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
            ]);
    
            // Generar un token para el usuario
            $token = $user->createToken('API Token')->accessToken;
    
            // Devolver la respuesta con el token
            return response()->json(['token' => $token], 201);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura los errores de validación
            return response()->json([
                'error' => 'Validation Error',
                'messages' => $e->errors()
            ], 422);
    
        } catch (\Exception $e) {
            // Captura otros errores generales
            return response()->json([
                'error' => 'Registration Error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request){
        try {
            $credentials = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);
    
            if (!Auth::attempt($credentials)) {
                return response()->json(['message' => 'Invalid login details'], 401);
            }
    
            $user = $request->user();
            $token = $user->createToken('API Token')->accessToken;
    
            return response()->json(['token' => $token], 200);
        }
        catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Validation Error',
                'messages' => $e->errors()
            ], 422);
        }
        catch (\Exception $e) {
            return response()->json([
                'error' => 'Login Error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
