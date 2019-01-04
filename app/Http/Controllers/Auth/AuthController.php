<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class AuthController extends Controller
{
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;

    public function login(Request $request){

        $this->request = $request;

        $this->validate($this->request, [
            'username'     => 'required',
            'password'  => 'required'
        ]);

        // Find the user by username
               
/*      @var $dbuser User */
        $dbuser;
        try {
            $dbuser = User::where('username', $this->request->input('username'))->first();
            
            if (!$dbuser) {
                return response()->json([
                    'errors' => ['Bad request' => 'User does not exist.']
                ], 400);
            }
        
        } catch (QueryException $ex) {
            return response()->json([
                'errors' => ['Bad request' => 'The request cannot be completed at the moment']
            ], 400);
        } catch (Exception $ex) {
            return reponse()->json([
                'errors' => ['Bad request' => 'Something bad happened']
            ]);
        }
        
        // Verify the password and generate the token
        if (Hash::check($this->request->input('password'), $dbuser->password)) {
            return response()->json([
                'user' => $dbuser->attachToken($this->generateToken($dbuser))
            ], 200);
        }
    
        // Bad Request response
        return response()->json([
            'errors' => 'Username or password is wrong.'
        ], 400);


    }
    
    public function get(Request $request){
        $this->request = $request;
        $user = $this->request->auth;
         return [ 'user' => $user ];
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
