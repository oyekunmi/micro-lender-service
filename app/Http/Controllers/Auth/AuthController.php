<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;

    public function __invoke(Request $request){

        $this->request = $request;

        $this->validate($this->request, [
            'username'     => 'required',
            'password'  => 'required'
        ]);

        // Find the user by username
        $dbuser = User::where('username', $this->request->input('username'))->first();
        
//        die($dbuser);
        
        if (!$dbuser) {
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
        
        return JWT::encode($payload, env('JWT_SECRET'));
    }
}
