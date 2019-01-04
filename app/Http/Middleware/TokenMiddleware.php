<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use \Firebase\JWT\SignatureInvalidException;

class TokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $authorization = $request->header('Authorization');
        
        if(!$authorization) {
            // Unauthorized response if token not there
            return response()->json([
                'error' => 'Token not provided.'
            ], 401);
        }
        
        $matches = "";
        preg_match('/Bearer\s(\S+)/', $authorization, $matches);
        $token = $matches[1];
        
        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch(ExpiredException $e) {
            return response()->json([
                'error' => 'Provided token is expired.'
            ], 400);
        } catch (SignatureInvalidException $ex){
              return response()->json([
                'error' => 'Invalid token supplied.'
            ], 400);
        }catch(Exception $e) {
            return response()->json([
                'error' => 'An error while decoding token.'
            ], 400);
        }
        
        $request->auth = User::find($credentials->sub)->attachToken($token);
        $response = $next($request);

        return $response;
    }
}
