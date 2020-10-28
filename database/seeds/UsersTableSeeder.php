<?php


use App\User;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 10; $i++) { 
            $userNew = new User();
            $userNew->name = $faker->name;
            $userNew->email = $faker->safeEmail;
            $userNew->password = Hash::make('prova');
            $userNew->role_id = 1;

            $userNew->save();
        }
    }
}
