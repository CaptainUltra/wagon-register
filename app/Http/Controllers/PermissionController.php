<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Http\Resources\Permission as PermissionResource;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Permission::class);

        return PermissionResource::collection(Permission::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        $this->authorize('view', $permission);
        
        return new PermissionResource($permission);
    }
}
