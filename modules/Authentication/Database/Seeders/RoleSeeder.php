<?php

namespace Modules\Authentication\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Authentication\Enums\Sex;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::updateOrCreate(['name' => 'admin']);

        User::updateOrCreate(
            ['email' => 'sorena.fakhfoori2@gmail.com'],
            [
                'first_name' => 'sorena',
                'last_name' => 'fakhfoori',
                'sex' => Sex::MALE,
                'birth_date' => '2000-01-01',
                'password' => Hash::make(config('app.superadminpassword')),
            ]
        )->assignRole($admin);
    }
}
