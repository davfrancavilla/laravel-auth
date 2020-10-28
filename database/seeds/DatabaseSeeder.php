<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // prima users visto che posts prendono id da selenco users
            RolesTableSeeder::class,
            UsersTableSeeder::class,
            PostsTableSeeder::class,
            TagsTableSeeder::class,
            
        ]);
    }
}
