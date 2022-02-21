<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ActualizarUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {   
        $this->authorize('view',$user);

        return (new UserResource($user))
        ->response()
        ->setStatusCode(202);
    }

    public function getUserByEmail($email)
    {

        $this->authorize('view',User::class);
        $user = User::where('email',$email)
        ->firstOrFail();
        
        return (new UserResource($user))
                ->response()
                ->setStatusCode(200);
    }
    public function getUserByRol($rol)
    {
        $this->authorize('view',User::class);

        $user = User::where('rol',$rol)
        ->firstOrFail();
        
        return (new UserResource($user))
                ->response()
                ->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActualizarUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $user->update($request->all());
        return (new UserResource($user))
                ->additional(['msg' => 'Usuario actualizado Correctamente'])
                ->response()
                ->setStatusCode(202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
}
