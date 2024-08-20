<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Registrar usuarios.
     *
     * @group Usuarios
     * 
     * @bodyParam name string required Nombre del usuario
     * @bodyParam email string required Correo electrónico del usuario
     * @bodyParam password string required Contraseña del usuario
     *
     * @response 200 {
     *    "token": string
     * }
     * 
     * @response 422 {
     *    "error": "Validation Error",
     *    "messages": {
     *        "name": [
     *            "The name field is required."
     *        ],
     *        "email": [
     *            "The email field is required."
     *        ],
     *        "password": [
     *            "The password field is required."
     *        ]
     *    }
     * }
     * @response 500 {
     *    "error": "Registration Error",
     *    "message": "Internal Server Error"
     * }
     */
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
    
    /**
     * Autenticar usuarios.
     *
     * @group Usuarios
     * 
     * @bodyParam email string required Correo electrónico del usuario
     * @bodyParam password string required Contraseña del usuario
     *
     * @response 200 {
     *    "token": string
     * }
     * @response 422 {
     *    "error": "Validation Error",
     *    "messages": {
     *        "email": [
     *            "The email field is required."
     *        ],
     *        "password": [
     *            "The password field is required."
     *        ]
     *    }
     * }
     * @response 500 {
     *    "error": "Registration Error",
     *    "message": "Internal Server Error"
     * }
     */
    public function login(Request $request){
        try {
            // Validar los datos del request
            $credentials = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);
            // Verificar si el usuario existe
            if (!Auth::attempt($credentials)) {
                return response()->json(['message' => 'Invalid login details'], 401);
            }
            // Crear el token
            $user = $request->user();
            $token = $user->createToken('API Token')->accessToken;
            // Devolver la respuesta con el token
            return response()->json(['token' => $token], 200);
        }
        catch (\Illuminate\Validation\ValidationException $e) {
            // Captura los errores de validación
            return response()->json([
                'error' => 'Validation Error',
                'messages' => $e->errors()
            ], 422);
        }
        catch (\Exception $e) {
            // Captura otros errores generales
            return response()->json([
                'error' => 'Login Error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
