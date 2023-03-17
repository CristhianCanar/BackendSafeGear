<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthApiController extends Controller
{
    public function signIn(Request $request)
    {
        $credentials = ['email' => $request->correo,'password' => $request->contrasenia];
        try {
            if (!$jwt = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'Credenciales inválidas', "status" => "invalid"],400);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'Error en servidor'], 500);
        }
        $user_bd = auth()->user();
        return response()->json([ 'id_user'         => $user_bd->id,
                                  'identificacion'  => $user_bd->identificacion,
                                  'telefono'        => $user_bd->telefono,
                                  'nombre'          => $user_bd->nombre,
                                  'apellido'        => $user_bd->apellido,
                                  'jwt'             => $jwt,
                                  'status'          => 'success'], 200);
    }
}
