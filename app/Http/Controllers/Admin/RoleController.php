<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Http\Resources\RoleResource;
use App\Models\Log;
use App\Models\Role;

class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::all();
        return $this->success(RoleResource::collection($roles));
    }

    public function show(Role $role)
    {
        return $this->success(new RoleResource($role));
    }

    public function store(RoleStoreRequest $request)
    {

        $role = Role::query()->create([
            'name' => $request->get('name'),
        ]);

        Log::query()->create([
            'user_id' => auth()->id(),
            'action' => 'store',
            'description' => 'a role is stored'
        ]);

        return $this->success(new RoleResource($role));

    }

    public function update(RoleUpdateRequest $request, Role $role)
    {
        $role->update([
            'name' => $request->get('name'),
        ]);

        Log::query()->create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'description' => 'a role is updated'
        ]);

        return $this->success(new RoleResource($role));
    }

    public function destroy(Role $role)
    {
        if ($role->users()->count())
        {
            return $this->error("This role is used by a user");
        }
        $role->delete();

        Log::query()->create([
            'user_id' => auth()->id(),
            'action' => 'destroy',
            'description' => 'a role is destroyed'
        ]);

        return $this->success("role is deleted");
    }

}
