<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = config('store.admin_email');
        $password = config('store.admin_password');
        if (!$email || !$password || strlen($password) < 12) {
            $this->command?->warn('Set STORE_ADMIN_EMAIL and STORE_ADMIN_PASSWORD (at least 12 characters) to create the initial administrator.');
            return;
        }
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Super Admin Role
        $superAdminRole = Role::firstOrCreate([
            'name' => 'Super Admin',
            'guard_name' => 'web',
        ]);

        $user = User::firstOrCreate(
            [
                'email' => $email,
            ],
            [
                'name'          => 'Super Admin',
                'username'      => 'superadmin',
                'type'     => 'super_admin',
                'status'        => 1,
                'password'      => Hash::make($password),
                'email_verified_at' => now(),
            ]
        );

        // Assign Role
        if ($user->type !== 'super_admin') {
            $this->command?->warn('This email belongs to an existing non-administrator; no privileges were changed.');
            return;
        }
        if (!$user->hasRole('Super Admin')) {
            $user->assignRole($superAdminRole);
        }
    }
}
