<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            $newRole = new Role();
            $newRole->role = 'user';
            $newRole->save();

            $newestRole = new Role();
            $newestRole->role = 'admin';
            $newestRole->save();
    }
}
