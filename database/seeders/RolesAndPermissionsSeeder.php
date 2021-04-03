<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permission = Permission::findOrCreate(User::PERMISSION_FILL_PURCHASE_ORDER);

        // create roles and assign created permissions
        Role::findOrCreate(User::ROLE_SUPER_ADMIN);

        $partnerRole = Role::findOrCreate(User::ROLE_PARTNER)
            ->givePermissionTo([User::PERMISSION_FILL_PURCHASE_ORDER]);

        $user = \App\Models\User::factory()->create([
            'name' => 'Example User',
            'email' => 'test@example.com',
        ]);
        $user->assignRole($partnerRole);
    }
}
