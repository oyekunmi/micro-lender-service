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
        
        $merchant = Role::create([
            'name' => 'Merchant', 
            'slug' => 'merchant',
            'permissions' => [
                'create-teller' => true
            ]
        ]);
        $teller = Role::create([
            'name' => 'Teller', 
            'slug' => 'teller',
            'permissions' => [
                'create-customer' => true
            ]
        ]);
        $customer = Role::create([
            'name' => 'Customer', 
            'slug' => 'customer',
            'permissions' => [
//                'create-post' => true,
            ]
        ]);
    }
    
}
