<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Exceptions\ApiException;
use App\Http\Requests\LoginRequest;
use Throwable;

class AuthController extends Controller
{
    public function login(LoginRequest $request, Client $http)
    {
        $params = $request->only(['username', 'password']);
        try {
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
        } catch (Throwable $e) {
            throw new ApiException($e->getMessage());
        }
        $token = json_decode((string)$resp->getBody(), true);

        return response()->json($token);
    }

    public function refreshToken(Request $request, Client $http)
    {
        $params = $request->only(['refresh_token']);
        if (empty($params['refresh_token'])) {
            throw new ApiException('refresh_token获取失败');
        }
        try {
            $resp = $http->post(config('app.url') . '/oauth/token', [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'client_id' => env('CLIENT_ID', ''),
                    'client_secret' => env('CLIENT_SECRET', ''),
                    'refresh_token' => $params['refresh_token']
                ]
            ]);
        } catch (Throwable $e) {
            throw new ApiException($e->getMessage());
        }
        $token = json_decode((string)$resp->getBody(), true);

        return response()->json(['token' => $token]);
    }
}
