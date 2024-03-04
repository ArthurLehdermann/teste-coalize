<?php

namespace app\services;

use app\models\User;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Yii;

class AuthService
{
    const JWT_SECRET_KEY = 'teste-secret-key';
    const JWT_ALGORITHM = 'HS256';

    /**
     * @throws Exception
     */
    public function authenticate($username, $password)
    {
        $user = $this->validateUser($username, $password);

        $tokens = $this->generateTokens($user);

        $this->saveUserTokens($user, $tokens);

        return $tokens;
    }

    /**
     * Refreshes the access token using the provided refresh token.
     *
     * @param string $refreshToken The refresh token.
     * @return array Returns an array containing the new access token and refresh token.
     * @throws Exception If the refresh token is invalid or expired.
     */
    public function refreshToken($refreshToken)
    {
        if (empty($refreshToken)) {
            throw new Exception(Yii::t('app', 'Invalid or expired refresh token'));
        }

        $user = User::findOne(['refresh_token' => $refreshToken]);
        if (empty($user)) {
            throw new Exception(Yii::t('app', 'Invalid or expired refresh token'));
        }

        $this->validateToken($refreshToken);

        $tokens = $this->generateTokens($user);

        $this->saveUserTokens($user, $tokens);

        return $tokens;
    }

    /**
     * @param null $token
     * @return void
     * @throws Exception
     */
    public function validateToken($token = null)
    {
        if (empty($token)) {
            throw new Exception(Yii::t('app', 'Invalid or expired token'));
        }

        $decoded = JWT::decode($token, new Key(self::JWT_SECRET_KEY, 'HS256'));
        if ($decoded->exp < time()) {
            throw new Exception(Yii::t('app', 'Invalid or expired token'));
        }
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

    private function generateTokens($user)
    {
        $time = time();

        $payload = [
            'id' => $user->id,
            'iat' => $time,
            'exp' => $time + (60*60), // token expires in 1 hour
        ];
        $accessToken = JWT::encode($payload, self::JWT_SECRET_KEY, self::JWT_ALGORITHM);

        $refreshTokenPayload = [
            'id' => $user->id,
            'iat' => $time,
            'exp' => $time + (60*60*24*7), // token expires in 7 days
        ];
        $refreshToken = JWT::encode($refreshTokenPayload, self::JWT_SECRET_KEY, self::JWT_ALGORITHM);

        return [
            'token' => $accessToken,
            'refresh_token' => $refreshToken
        ];
    }

    private function saveUserTokens($user, $tokens)
    {
        $user->token = $tokens['token'] ?? null;
        $user->refresh_token = $tokens['refresh_token'] ?? null;
        if (!$user->save()) {
            throw new Exception(Yii::t('app', 'Error saving user tokens'));
        }
    }
}
