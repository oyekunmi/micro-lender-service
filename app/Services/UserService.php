<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use App\Repositories\ProductRepository;
use App\Repositories\AccountRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserService{
   
    private $repo,$productRepo,$accountRepo,$roleRepo;
    
    function __construct(
            UserRepository $repo,
            RoleRepository $roleRepo,
            ProductRepository $productRepo,
            AccountRepository $accountRepo) {
        $this->repo = $repo;
        $this->roleRepo = $roleRepo;
        $this->accountRepo = $accountRepo;
        $this->productRepo = $productRepo;
    }
    
    function getCustomers($search=""){
        return $this->repo->getAllInRole('customer');
    }
    
    function getMerchants($search=""){
        return $this->repo->getAllInRole('merchant');
    }
    
    function getTellers($search=""){
        return $this->repo->getAllInRole('teller');
    }
    
   function getCustomerByUsername($username){
       return $this->repo->getByUsernameAndRole($username, "customer");
   }
   
   function validateUserData(array $userData){
       $validator = Validator::make($userData, [
            'username' => 'bail|required|unique:users',
            'name' => 'required',
            'email' => 'required|email',
            'profile' => 'required',
        ]);
       
       return $validator->fails() ? $validator->errors(): true;
   }
           
   function createUser(array $userData){
       
        DB::beginTransaction();
        
        try{
            $userObject = $this->userFactory($userData);
            
            $user = $this->repo->save($userObject);
            $user->roles()->attach( $this->roleRepo->getBySlug($userObject['role']) );
            $this->accountRepo->createAccount($user, $this->productRepo->getBySlug($userObject['product']), '150844847');
            
        } catch (Exception $ex) {
            DB::rollback();
            return $ex->message;
        } finally {
            
        }
        
        DB::commit();
        return response('Ok');

   }
   
   function deleteCustomerByUsername($username){
       return $this->repo->deleteByUsername($username);
   }
    
    
}