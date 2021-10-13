<?php

namespace Tests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function registerUser($role)
    {
        $role = Role::factory()->create([
            'name' => $role,
        ]);
        /** @var User $admin */
        $admin = User::factory()->create();
        $admin->roles()->attach($role->id);
        return $admin;
    }

}
