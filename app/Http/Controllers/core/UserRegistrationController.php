<?php

namespace App\Http\Controllers\core;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use App\Product;
use App\Account;

class UserRegistrationController extends Controller
{
    private $request ;

    /**
     * Sets up a new user
     *
     */
    public function __invoke(Request $request)
    {
        $this->request = $request;
        
        $this->validate($request, [
            'username'     => 'required',
            'name'  => 'required',
            'email' => 'required|email',
            'profile' => 'required'
        ]);
        
        DB::beginTransaction();
        
        try{
            $user = User::create($this->userFactory());
            $user->roles()->attach( $this->getRole() );
            $this->accountFactory($user, $this->getProduct())->save();
        } catch (Exception $ex) {
            DB::rollback();
        } finally {
            
        }
        
        DB::commit();

        return $user;
        
    }
    
    private function getRole(){
        $role = $this->request->role ?? 'customer';
        return Role::where('slug', $role)->first();
    }
    
    private function getProduct(){
        $product = $this->request->product?? 'savings';
        return Product::where('slug', $product)->first();
    }
    
    private function getProfile(){
        $product = json_decode($this->request->profile);
        return $product;
    }
    
    private function userFactory(){
        return [
            'name' => $this->request->name,
            'email' => $this->request->email,
            'username' => $this->request->username,
            'password' => app('hash')->make('67544989542'),
            'profile' => json_encode($this->getProduct())
        ];
    }
    
    private function accountFactory(User $user, $product){
        $account = new Account;
        $account->account_no = '150844847';
        $account->account_name = $user->name;
        $account->user()->associate($user);
        $account->product()->associate($product);
        return $account;
    }
    
    
}