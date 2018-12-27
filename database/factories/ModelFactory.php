<?php
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'username' => $faker->userName,
        'email' => $faker->email,
        'password' => Hash::make('12345'),
        'profile' => json_encode([
            'start_date' => 'Carbon::yesterday()->toDateString()',
            'end_date' =>  'Carbon::now()->toDateString()',
            'thing' => rand(11,99),
        ])
    ];
});
$factory->define(App\Account::class, function (Faker\Generator $faker)  {
    return [
        'account_no' => $faker->bankAccountNumber,
        'account_name' => $faker->name
    ];
});
