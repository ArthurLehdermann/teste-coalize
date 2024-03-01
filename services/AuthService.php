<?php
namespace app\services;

use app\models\User;
use Exception;
use Firebase\JWT\JWT;

class AuthService
{
    public function authenticate($username, $password)
    {
        $user = User::findOne(['username' => $username]);

        if (!$user || !$user->validatePassword($password)) {
            throw new Exception('Nome de usuário ou senha inválidos');
        }

        $payload = [
            'iss' => 'teste-app',
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + (60*60*24), // token expires in 24 hour
        ];

        return JWT::encode($payload, 'teste-secret-key', 'HS256');
    }
}
