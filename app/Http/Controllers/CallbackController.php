<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Throwable;

class CallbackController extends Controller
{
    public function lineOauthCallback(Request $request, Client $http, User $user)
    {
        $code = $request->get('code', '');
        $state = $request->get('state', '');

        $params = [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => config('app.url') . '/callback/line/callback',
            'client_id' => env('LINE_CLIENT_ID'),
            'client_secret' => env('LINE_CLIENT_SECRET')
        ];
        try {
            $resp = $http->request('POST', 'https://api.line.me/oauth2/v2.1/token', [
                'form_params' => $params,
            ]);
        } catch (Throwable $e) {
            die($e->getMessage());
        }
        // [access_token,expires_in,id_token,refresh_token,scope,token_type]
        $lineToken = json_decode((string)$resp->getBody(), true);
        if (!empty($lineToken['error'])) {
            echo ('error:' . $lineToken['error'] . ' error_description:' . $lineToken['error_description']);
            return;
        }

        $params = [
            'id_token' => $lineToken['id_token'],
            'client_id' => env('LINE_CLIENT_ID'),
        ];
        try {
            $resp = $http->request('POST', 'https://api.line.me/oauth2/v2.1/verify', [
                'form_params' => $params,
            ]);
        } catch (Throwable $e) {
            die($e->getMessage());
        }
        // ['iss', 'sub', 'aud', 'exp', 'iat', 'nonce', 'amr', 'name', 'picture', 'email']
        $data = json_decode((string)$resp->getBody(), true);
        if (!empty($data['error'])) {
            echo ('error:' . $data['error'] . ' error_description:' . $data['error_description']);
            return;
        }
        if (empty($data['email'])) {
            echo 'Line 账号未绑定Email';
            return;
        }
        $uinfo = $user->where('email', $data['email'])->first();
        if (empty($uinfo)) {
            $data = [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => '',
                'enable' =>  User::ENABLE_TRUE,
                'role' => User::ROLE_STUDENT,
                'line_openid' => $lineToken['id_token']
            ];
            $uinfo = User::create($data);
        } else {
            $uinfo->line_openid = $lineToken['id_token'];
            $uinfo->save();
        }

        $tokenResult =  $uinfo->createToken('Personal Access Token', ['*']);
        $token = [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ];

        return view('welcome')->with('token', json_encode($token));
    }
}
