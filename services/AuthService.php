<?php

namespace app\services;

use app\models\User;
use Exception;
use Firebase\JWT\JWT;
use Yii;

class AuthService
{
    const JWT_ISSUER = 'teste-app';
    const JWT_SECRET_KEY = 'teste-secret-key';
    const JWT_ALGORITHM = 'HS256';

    /**
     * @throws Exception
     */
    public function authenticate($username, $password)
    {
        $user = $this->validateUser($username, $password);

        $token = $this->generateToken($user);

        $this->saveUserToken($user, $token);

        return $token;
    }

    /**
     * @throws Exception
     */
    private function validateUser($username = null, $password = null)
    {
        if (is_null($username) || trim($username) === '' || is_null($password) || trim($password) === '') {
            throw new Exception(Yii::t('app', 'Username and password must not be empty'));
        }

        $user = User::findOne(['username' => $username]);

        if (!$user || !$user->validatePassword($password)) {
            throw new Exception(Yii::t('app', 'Invalid username or password'));
        }

        return $user;
    }

    private function generateToken($user)
    {
        $payload = [
            'iss' => self::JWT_ISSUER,
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + (60*60*24), // token expires in 24 hour
        ];

        return JWT::encode($payload, self::JWT_SECRET_KEY, self::JWT_ALGORITHM);
    }

    private function saveUserToken($user, $token)
    {
        $user->token = $token;
        if (!$user->save()) {
            throw new Exception(Yii::t('app', 'Error saving user token'));
        }
    }
}
