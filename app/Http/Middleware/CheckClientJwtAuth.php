<?php

namespace App\Http\Middleware;

use App\Libraries\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Exception;
use JWTAuth;
use Illuminate\Support\Facades\App;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class CheckClientJwtAuth extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

         $token = JWTAuth::getToken();

        if (!empty($token)) {

            try {
                $data = JWTAuth::decode($token);
                // Check if this user still available
                if ($data['sub']) {
                    $request->user_id = $data['sub'];
                    if (isset($request->language))
                    App::setLocale($request->language);
                    return $next($request);
                }
                return ApiResponse::errors(["User not exists or deleted"],402);
            }
            catch (Exception $e) {

                if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                    return ApiResponse::errors(['Token is Invalid'],401);
                }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                    return ApiResponse::errors(['Token is Expired'],451);
                }else{
                    return ApiResponse::errors(['Authorization Token not found'],401);
                }
            }

        } else {
            return ApiResponse::errors(["Unauthenticated"],401);
        }
    }
}
