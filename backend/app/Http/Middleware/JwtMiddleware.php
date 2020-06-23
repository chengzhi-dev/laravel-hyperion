<?php
namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
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
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                $error = 'Token is Invalid';
                $code = 401;
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                $error = 'Token is Expired';
                $code = 401;
            }else{
                $error = 'Authorization Token not found';
                $code = 401;
            }
            
            $response = [
                'success' => false,
                'message' => $error,
            ];
            return response()->json($response, $code)->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', '*')
            ->header('Access-Control-Allow-Headers', '*');
        }
        return $next($request);
    }
}