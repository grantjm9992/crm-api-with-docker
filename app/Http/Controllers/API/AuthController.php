<?php

namespace App\Http\Controllers\API;

use App\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use Illuminate\Support\Facades\Validator;

class AuthController  extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        if (!isset($input['company_id'])) {
            if (!isset($input['company_name'])) {
                return $this->sendError('company_name_needed', ['Company name not found. Nor ID']);
            }
            $company = Company::create(['name' => $input['company_name']]);
            $input['company_id'] = $company->getAttribute('id')->toString();
        }
        $user = User::create($input);
        $user->password = md5($request->password);
        $user->save();

        return $this->sendResponse(['success' => true], 'User register successfully.');
    }

    public function routes(): JsonResponse
    {
        $routeArray = [[
            'id' => 'example',
            'title' => 'Example',
            'type' => 'basic',
            'icon' => 'heroicons_outline:chart-pie',
            'link' => '/example'
        ]];

        $routes = [
            'compact' => $routeArray,
            'default' => $routeArray,
            'futuristic' => $routeArray,
            'horizontal' => $routeArray
        ];
        return response()->json($routes, 200);
    }

    public function login(Request $request)
    {
        if(User::where(['email' => $request->email])->first()){
            $user = User::where(['email' => $request->email])->first();
            $success = array(
                'token' => $user->generateToken(),
                'user' => $user,
                'routes' => [
                    [
                        'id' => 'example',
                        'title' => 'Example',
                        'type' => 'basic',
                        'icon' => 'heroicons_outline:chart-pie',
                        'link' => '/example'
                    ]
                ]
            );

            return $this->sendResponse($success, 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }
}
