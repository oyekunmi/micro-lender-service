<?php

namespace App\Http\Controllers\Teller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Services\UserService;

class CustomerController extends Controller
{
    private $request ;
    private $service;
    
    function __construct(UserService $service) {
        $this->service = $service;
    }
    
    function index($search = ''){
        return $this->service->getCustomers($search);
    }

    function create(Request $request){
        $userData = $request->input();
        
        if(!is_bool($isValid = $this->service->validateUserData($userData))){
            return response($isValid, 400);
        }
        
        $result = $this->service->createUser($userData);
        
        if($result){
            return $result;
        }
    }
    
    
    
}