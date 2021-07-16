<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\User;
use Exception;
use Illuminate\Http\JsonResponse;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return string|null
     */
    protected function redirectTo($request)
    {
        $authWithBearer = $request->header('Authorization');
        if ($authWithBearer) {
            $authWithoutBearer = substr($authWithBearer, 7);
            $user = User::where('api_token', $authWithoutBearer)->first();
            if (!$user) {
                abort(response()->json(['status' => 401, 'error' => 'Unauthorized'], 401));
            }
            // dd('2');
        } else {
            abort(response()->json(['status' => 401, 'error' => 'Unauthorized'], 401));   
        }
    }
}
