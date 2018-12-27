<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 10)->create()->each(function($user) {
         $randRole = App\Role::find(rand(1, 3));
         $user->roles()->attach($randRole);
        });
    }
}
