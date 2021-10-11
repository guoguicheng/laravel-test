<?php

namespace App\Http\Controllers;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CallbackController extends Controller
{
    public function lineOauthCallback(Request $request, Client $http)
    {
        $code = $request->get('code', '');
        $state = $request->get('state', '');

        $params = [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => urlencode(config('app.url') . '/callback/line/token'),
            'client_id' => env('LINE_CLIENT_ID'),
            'client_secret' => env('LINE_CLIENT_SECRET')
        ];
        dump($params);
        die;
        $resp = $http->request('POST', 'https://api.line.me/oauth2/v2.1/token', [
            'form_params' => $params,
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ]
        ]);
    }

    public function lineOauthTokenCallback(Request $request, Client $http, User $user)
    {
        $data = $request->only(['access_token', 'expires_in', 'id_token', 'refresh_token', 'scope', 'token_type']);

        $params = [
            'id_token' => $data['id_token'],
            'client_id' => env('LINE_CLIENT_ID'),
            'client_secret' => 'a1f8153433b456af8c593ea4ac1c1467'
        ];
        $resp = $http->request('POST', 'https://api.line.me/oauth2/v2.1/verify', [
            'form_params' => $params,
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ]
        ]);

        $pwd = 'Acdid274hlHLdlsdfs_|^';
        // ['iss', 'sub', 'aud', 'exp', 'iat', 'nonce', 'amr', 'name', 'picture', 'email']
        $data = json_decode((string)$resp->getBody(), true);

        $uinfo = $user->where('email', $data['email'])->first();
        if (empty($uinfo)) {
            $data = [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($pwd),
                'enable' =>  User::ENABLE_TRUE,
                'role' => User::ROLE_STUDENT
            ];
            User::create($data);
        }

        $resp = $this->http->post(config('app.url') . '/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'username' => $data['email'],
                'password' => $pwd,
                'client_id' => env('CLIENT_ID'),
                'client_secret' => env('CLIENT_SECRET'),
                'scopt' => '*'
            ]
        ]);

        $token = $resp->getBody();

        return view('home', ['token' => $token]);
    }
}
