<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use App\Repositories\ProductRepository;
use App\Repositories\AccountRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

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
           

   
   public function createCustomer($customerData){
       $customerObject = $this->customerRequestFactory($customerData);
       return $this->createUser($customerObject);
   }
   
   public function deleteCustomerByUsername($username){
       return $this->repo->deleteByUsername($username);
   }
   
      private function createUser(array $userObject){
       
        DB::beginTransaction();
        
        try{            
            $user = $this->repo->save($userObject);
            $user->roles()->attach( $this->roleRepo->getBySlug($userObject['role']) );
            $this->accountRepo->createAccount($user, $this->productRepo->getBySlug($userObject['product']), '150844847');
            
        } catch (Exception $ex) {
            DB::rollback();
            return false;
        }catch (QueryException $ex) {
            DB::rollback();
            return false;
        } finally {
            
        }
        
        DB::commit();
        
        return $user;

   }
   
   private function customerRequestFactory($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => app('hash')->make('67544989542'),
            'role' => 'customer',
            'product' => $request->product ?? 'savings',
            'profile' => json_encode($this->buildCustomerProfile($request))
        ];
    
   }
   private function buildCustomerProfile($request) {
      return json_encode('{}');
   }
    
    
}