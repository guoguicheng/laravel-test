<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\User;
use ErrorException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    private $http;
    private $user;
    function __construct(Client $http, User $user)
    {
        $this->http = $http;
        $this->user = $user;
    }
    public function register(RegisterRequest $request)
    {
        $inviteToken = $request->token;

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'enable' => $request->role != User::ROLE_SCHOOL ? User::ENABLE_TRUE : User::ENABLE_FALSE,
            'role' => $request->role ?? User::ROLE_STUDENT
        ];

        if ($inviteToken) {
            $inviteUserInfo = $this->user->find($inviteToken);
            if (empty($inviteUserInfo)) {
                throw new ApiException('邀请人不存在', 422);
            }
            if ($inviteUserInfo->role !== User::ROLE_SCHOOL) {
                throw new ApiException('只有学校才能邀请教师', 422);
            }
            $data['pid'] = $inviteUserInfo->id;
            $data['role'] = User::ROLE_TEACHER;
        }
        User::create($data);

        $resp = $this->http->post(config('app.url') . '/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'username' => $request->email,
                'password' => $request->password,
                'client_id' => 5,
                'client_secret' => 'YwJ1pjaj3TxWR5NwfoIiL3y3tO7kbsti7fpE6Oj9',
                'scopt' => '*'
            ]
        ]);

        $token = json_decode((string)$resp->getBody(), true);

        return response()->json(['token' => $token], 201);
    }
}
