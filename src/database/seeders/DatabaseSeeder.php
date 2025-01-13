<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Project Manager']);
        Role::create(['name' => 'Developer']);
        Role::create(['name' => 'Tester']);
        Role::create(['name' => 'Client']);

        Permission::create(['name' => 'view projects']);
        Permission::create(['name' => 'create projects']);
        Permission::create(['name' => 'edit projects']);
        Permission::create(['name' => 'delete projects']);
        Permission::create(['name' => 'assign projects']);

        Permission::create(['name' => 'create tasks']);
        Permission::create(['name' => 'edit tasks']);
        Permission::create(['name' => 'delete tasks']);
        Permission::create(['name' => 'assign tasks']);

        User::factory()->create([
            'name' => 'Mateusz Serwinowski',
            'email' => 'mateusz.serwinowski@gmail.com',
        ]);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'test@example.com',
        ]);

        User::factory(10)->create();

        Project::factory()
            ->hasTasks(5)
            ->count(10)
            ->create();
    }
}
