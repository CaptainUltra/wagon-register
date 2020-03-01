<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User as UserResource;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->has('show-roles') && request('show-roles')){
            $users = User::with('roles')->paginate(15);;
        }
        else{
            $users = User::paginate(15);
        }
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validateRequest();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'api_token' => Str::random(32)
        ]);
        if($data['roles'] != null)
        {
            $roles = $data['roles'];
            $user->roles()->sync($roles);
        }
        else
        {
            $user->roles()->sync([1]);
        }

        if(request()->has('show-roles') && request('show-roles')){
            $userId = $user->id;
            $user = User::with('roles')->find($userId);
        }

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if(request()->has('show-roles') && request('show-roles')){
            $userId = $user->id;
            $user = User::with('roles')->find($userId);
        }
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $roles = $this->validateRequest()['roles'];
        $user->roles()->sync($roles);
        
        $user->update($this->validateRequest());

        if (request()->has('show-roles') && request('show-roles')) {
            $userId = $user->id;
            $user = User::with('roles')->find($userId);
        }

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }
    /**
     * Validate data from request.
     * 
     * @return mixed
     */
    private function validateRequest()
    {
        return request()->validate([
            'name' => 'required_without:roles',
            'email' => 'required_without:roles|email',
            'password' => 'required_without:roles',
            'roles' => ''
        ]);
    }
}
