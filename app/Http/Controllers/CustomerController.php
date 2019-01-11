<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Services\UserService;

class CustomerController extends Controller{
    
    /**
     *
     * @var Request 
     */
    private $request;
    
    /**
     *
     * @var UserService
     */
    private $userService;
    
    function __construct(
        Request $request, 
        UserService $userService
    ) {
        $this->request = $request;
        $this->userService = $userService;
    }
    
    
    function index(){
        return $this->userService->getCustomers();
    }
    
    /**
     * 
     * @param string $username
     * @return \App\User
     */
    function show(string $username){
        $user = $this->userService->getCustomerByUsername($username);
        return $user ? $user : response()->json([
                    'errors' => [ 'Customer does not exist.']
                ], 400);
        
    }
    
    /**
     * 
     * @return \App\User
     */
    function store(){
         $userData = $this->request->input();
        
        if(!is_bool($isValid = $this->userService->validateUserData($userData))){
            return response($isValid, 400);
        }
        
        $result = $this->userService->createCustomer($this->request);
        
        if($result ){
            return $result;
        }else{
            return 
            response()->json([
                    'errors' => [ 'cannot create customer due to bad data.']
                ], 400);
        }
    }
    
    /**
     * 
     * @param string $username
     */
    function update(string $username){
        
        $customer = $this->userService->getCustomerByUsername($username);
        if(!$customer) { 
            response()->json([
                    'errors' => [ 'Customer does not exist.']
                ], 400);
        }
        
        $result = $this->userService->updateCustomer($this->request->input(), $customer);
        
        if($result){ 
            return $result;
        }
        else { 
            return response()->json([
                    'errors' => [ 'Failed to update customer.']
                ], 400);
        }
    }
    
    
    function delete(string $username){
        try{
            $this->userService->deleteCustomerByUsername($username);
        } catch (Exception $ex) {
            return response()->json([
                    'errors' => [ 'Failed to delete customer.']
                ], 400);
        } finally {
            return response()->json('Ok');
        }
    }
}
