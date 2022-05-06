<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'users' => User::select('nombre', 'apellido', 'edad')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->datosNoValidosParaUsuarioNuevo($request)) {
            return response()->json([
                'validar datos' => 'nombre como cadena al igual que el apellido y edad numerica',
            ], 400);
        }

        User::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'edad' => $request->edad,
        ]);

        return response()->json([
            'usuarioCreado' => true,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json([
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if ($this->datosNoValidosParaUsuarioNuevo($request)) {
            return response()->json([
                'validar datos' => 'nombre como cadena al igual que el apellido y edad numerica',
            ], 400);
        }

        $user->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'edad' => $request->edad,
        ]);

        return response()->json([
            'actualizado' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);

        return response()->json([
            'eliminado' => true,
        ]);
    }

    protected function datosNoValidosParaUsuarioNuevo($request)
    {
        //validate the incoming request
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|min:1',
            'apellido' => 'required|string|min:1',
            'edad' => 'required|numeric|min:0',
        ]);
        return $validator->fails();
    }
}
