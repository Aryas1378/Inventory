<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::factory()->create([
            'name' => 'admin',
        ]);
        /** @var User $admin */
        $admin = User::factory()->create();
        $admin->roles()->attach($role->id);

    }
}
