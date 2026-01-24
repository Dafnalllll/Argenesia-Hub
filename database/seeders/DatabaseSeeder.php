<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $hrRoleId = DB::table('roles')->where('name', 'HR')->value('id');
        $adminRoleId = DB::table('roles')->where('name', 'admin')->value('id');

        User::factory()->create([
            'name' => 'HR',
            'email' => 'hrarge@gmail.com',
            'password' => bcrypt('HRArgenesia'),
            'role_id' => $hrRoleId,
            'status' => 'Aktif', // <-- tambahkan ini
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'adminarge@gmail.com',
            'password' => bcrypt('AdminArgenesia'),
            'role_id' => $adminRoleId,
            'status' => 'Aktif', // <-- tambahkan ini
        ]);
    }
}
