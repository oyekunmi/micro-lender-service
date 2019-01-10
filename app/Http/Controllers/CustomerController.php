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
    function show($username){
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
        
        $result = $this->userService->createCustomer($userData);
        
        if($result){
            return $result;
        }else{
            return $this->userService->createCustomerErrors();
        }
    }
}
