<?php

namespace Emtudo\Units\Auth\Http\Controllers;

use Emtudo\Domains\Users\Transformers\AuthTransformer;
use Emtudo\Support\Http\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request, Guard $auth)
    {
        $credentials = $this->getCredentials($request->only(['username', 'password']));
        if ($auth->attempt($credentials)) {
            return $this->respond->ok($auth, null, ['user.tenant', 'user.tenants', 'user.profiles', 'user.have_profiles'], [], [], new AuthTransformer());
        }

        return $this->respond->error('Erro ao autenticar.');
    }

    public function refresh(Request $request, Guard $auth)
    {
        // refresh token.
        $token = $auth->refresh();

        if (!$token) {
            return $this->respond->error('Erro ao atualizar token.');
        }

        return $this->respond->ok($auth, null, ['user.tenant', 'user.tenants', 'user.profiles', 'user.have_profiles'], [], [], new AuthTransformer());
    }

    protected function getCredentials(array $data)
    {
        $credentials = $data;
        $username = array_get($credentials, 'username');
        if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $credentials['country_register'] = $username;
        } else {
            $credentials['email'] = $username;
        }
        unset($credentials['username']);

        return $credentials;
    }
}
