<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
#use Tymon\JWTAuth\Exceptions\JWTException;
#use Tymon\JWTAuth\Facades\JWTAuth;

class AuthApiController extends Controller
{
    //Funtion Login
 /*   
    public function signIn(Request $request)
    {
        $credentials = ['identification' => $request->identification,'password' => $request->password];
        try {
            if (!$jwt = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'Credenciales invalidas', "status" => "invalid"],400);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'Error en servidor'], 500);
        }
        //validar autenticación
        $user_bd = auth()->user();
        return response()->json([ "id_user" => $user_bd->id_user,
                                  "name"    => $user_bd->name, 
                                  "jwt"     => $jwt, 
                                  "status"  => "success"], 200);
    }
    */
}
