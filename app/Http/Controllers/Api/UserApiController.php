<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\GetUserResource;
use App\Models\Rol;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{
    public function getUserById(int $userId): JsonResponse
    {
        $response = response()->json(['message' => 'Error en consulta de vehículo', "status" => "invalid"], 500);
        $usuario = User::where('id', $userId)->first();
        if ($usuario instanceof User) {
            $response = response()->json(new GetUserResource($usuario), 200);
        }
        return $response;
    }
    public function updateUser(Request $request, int $userId): JsonResponse
    {
        $response = response()->json(['message' => 'Error en actualización de usuario', "status" => "invalid"], 500);
        $usuario = User::where('id', $userId)->first();

        if ($usuario instanceof User) {
            try {
                $usuario = User::where('id', $usuario->id)->update([
                    'nombre'         => $request->nombre,
                    'apellido'       => $request->apellido,
                    'telefono'       => $request->telefono,
                    'identificacion' => $request->identificacion,
                    'email'          => $request->correo
                ]);

                if ($usuario) {
                    $response = response()->json(['id' => $userId, 'status' => 'success'], 201);
                } elseif (!$usuario) {
                    $response = response()->json(['message' => 'Error actualizar usuario', "status" => "invalid"], 500);
                }
            } catch (Exception $e) {
                $response = response()->json(['message' => 'Error en actualizar: ' . $e->getMessage(), "status" => "invalid"], 500);
            }
        }

        return $response;
    }
    public function storeUser(Request $request): JsonResponse
    {
        $rol  = Rol::where('rol', $request->rol)->first();

        if (($rol instanceof Rol) )
        {
            try {
                $usuario = new User();
                $usuario->nombre                = $request->nombre;
                $usuario->email                = $request->correo;
                $usuario->password           = Hash::make($request->contrasenia);
                $usuario->rol_id                = $rol->id;
                $usuario->save();
                return response()->json(['id' => $usuario->id, 'status' => 'success'], 201);
                if($usuario){
                    $request = new Request();
                    $request['correo'] = $usuario->email ;
                    $request['contrasenia'] = $usuario->password;

                    $objeto = new AuthApiController();
                    $v = $objeto->signIn($request);
                    return $this->$v;
                }
            } catch (Exception $e) {
                return response()->json(['message' => 'Error en registro: ' . $e->getMessage(), "status" => "invalid"], 500);
            }
        }
        return response()->json(['message' => 'Error en registro', "status" => "invalid"], 500);
    }

    public function deleteUser(int $userId): JsonResponse
    {
        $response = response()->json(['message' => 'Error al eliminar el vehículo', "status" => "invalid"], 500);
        try {
            $userDeleted = User::where('id', $userId)->delete();
            if($userDeleted){
                $response = response()->json(['status' => 'success'], 200);
            } elseif(!$userDeleted){
                $response = response()->json(['message' => 'No fue posible eliminar el usuario', "status" => "invalid"], 400);
            }
        } catch (Exception $e) {
            $response = response()->json(['message' => 'Error al eliminar el usuario'.$e->getMessage(), "status" => "invalid"], 500);
        }
        return $response;
    }
}
