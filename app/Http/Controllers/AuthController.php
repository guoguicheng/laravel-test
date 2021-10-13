<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Exceptions\ApiException;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request, Client $http)
    {
        $params = $request->only(['username', 'password']);
        $resp = $http->post(config('app.url') . '/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'username' => $params['username'],
                'password' => $params['password'],
                'client_id' => env('CLIENT_ID', ''),
                'client_secret' => env('CLIENT_SECRET', ''),
                'scope' => '*'
            ]
        ]);
        $token = json_decode((string)$resp->getBody(), true);

        return response()->json($token);
    }

    public function refreshToken(Request $request, Client $http)
    {
        $params = $request->only(['refresh_token']);
        if (empty($params['refresh_token'])) {
            throw new ApiException('refresh_token获取失败');
        }
        $resp = $http->post(config('app.url') . '/oauth/token', [
            'form_params' => [
                'grant_type' => 'refresh_token',
                'client_id' => env('CLIENT_ID', ''),
                'client_secret' => env('CLIENT_SECRET', ''),
                'refresh_token' => $params['refresh_token']
            ]
        ]);
        $token = json_decode((string)$resp->getBody(), true);

        return response()->json(['token' => $token]);
    }
}
