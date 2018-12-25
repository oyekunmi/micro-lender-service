<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }


    public function authenticate(){
        
        $this->validate($this->request, [
            'username'     => 'required',
            'password'  => 'required'
        ]);

        // Find the user by username
        $dbuser = User::where('username', $this->request->input('username'))->first();

        if (!$dbuser) {
            // You wil probably have some sort of helpers or whatever
            // to make sure that you have the same response format for
            // differents kind of responses. But let's return the 
            // below respose for now.
            return response()->json([
                'error' => 'User does not exist.'
            ], 400);
        }

        // Verify the password and generate the token
        if (Hash::check($this->request->input('password'), $dbuser->password)) {
            return response()->json([
                'access_token' => $this->generateToken($dbuser)
            ], 200);
        }
    
        // Bad Request response
        return response()->json([
            'error' => 'Username or password is wrong.'
        ], 400);


    }

    private function generateToken(User $user){
        $payload = [
            'iss' => "microlender", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued. 
            'exp' => time() + 60*60 // Expiration time
        ];
        
        
        // As you can see we are passing `JWT_SECRET` as the second parameter that will 
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    }
}
