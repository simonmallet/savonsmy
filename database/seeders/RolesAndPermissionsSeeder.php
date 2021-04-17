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
        $adminRole = Role::findOrCreate(User::ROLE_SUPER_ADMIN);

        $partnerRole = Role::findOrCreate(User::ROLE_PARTNER)
            ->givePermissionTo([User::PERMISSION_FILL_PURCHASE_ORDER]);

        $partnerUser = User::where('email', 'partner@mysite.com')->first();
        if (!$partnerUser) {
            $user = \App\Models\User::factory()->create([
                'name' => 'Partner User',
                'email' => 'partner@mysite.com',
            ]);
            $user->assignRole($partnerRole);
        }

        $adminUser = User::where('email', 'admin@mysite.com')->first();
        if (!$adminUser) {
            $user = \App\Models\User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@mysite.com',
            ]);
            $user->assignRole($adminRole);
        }
    }
}
