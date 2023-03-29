<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthApiController extends Controller
{
    public function userRegister(Request $request)
    {
        $nombre    = $request->nombre;
        $email     = $request->correo;
        $password  = $request->contrasenia;
        try {
            $user = User::create([
                        'rol_id'   => "1",
                        'nombre'   => $nombre,
                        'email'    => $email,
                        'password' => Hash::make($password),
                    ]);
            if($user){
                $request = new Request();
                $request['correo'] = $email;
                $request['contrasenia'] = $password;
                return $this->signIn($request);
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Error en servidor 1: '.$e->getMessage(), "status" => "invalid"], 500);
        }
        return response()->json(['message' => 'Error en registro', "status" => "invalid"], 500);
    }

    public function signIn(Request $request)
    {
        $credentials = ['email' => $request['correo'], 'password' => $request['contrasenia']];
        try {
            if (!$jwt = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'Credenciales inválidas', "status" => "invalid"],400);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'Error en servidor: '.$e->getMessage(), "status" => "invalid"], 500);
        }
        $user_bd = auth()->user();
        return response()->json([ 'id_user'         => $user_bd->id,
                                  'rol_id'          => $user_bd->roles->id,
                                  'identificacion'  => $user_bd->identificacion,
                                  'telefono'        => $user_bd->telefono,
                                  'nombre'          => $user_bd->nombre,
                                  'apellido'        => $user_bd->apellido,
                                  'jwt'             => $jwt,
                                  'status'          => 'success'], 200);
    }

    public function logout() {
        Auth::guard('api')->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'logout'
        ], 200);
    }
}
