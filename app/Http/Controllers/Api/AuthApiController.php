<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthApiController extends Controller
{
    public function register(Request $request)
    {
        /* VAL
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
        }
        */
        $nombre     = $request->name;
        $apellido   = $request->lastname;
        $user = User::create([
                    // El rol sera 4 = Cliente
                    'rol_id'            => 4,
                    'nombre'            => $nombre,
                    'apellido'          => $apellido,
                    'email'             => $request->email,
                    'password'          => Hash::make($request->password),
                    'telefono'          => "321",
                    'medio_registro'    => "API-MOVIL"
                ]);
        $user_json = [
            "user" => [
                "__v" => 0,
                "_id" => $user->id_user,
                "blocked" => $user->bloqueado,
                "confirmed" => $user->verificado,
                "createdAt" => $user->created_at,
                "email" => $user->email,
                "id" => $user->id_user,
                "provider" => "local",
                "role" => [
                  "__v" => 0,
                  "_id" => $user->rol_id,
                  "description" => $user->rol->descripcion,
                  "id" =>  $user->rol_id,
                  "name" => $user->rol->rol,
                  "type" => $user->rol->rol,
                ],
                "services" => [],
                "updatedAt" => $user->updated_at,
                "username" => $user->email,
            ]
        ];
        return response()->json($user_json);
    }
    public function signIn(Request $request)
    {
        $credentials = ['email' => $request->correo,'password' => $request->contrasenia];
        try {
            if (!$jwt = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'Credenciales inválidas', "status" => "invalid"],400);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'Error en servidor: '.$e->getMessage()], 500);
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
