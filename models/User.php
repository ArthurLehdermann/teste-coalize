<?php

namespace app\models;

use app\services\AuthService;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property string|null $token
 * @property string|null $refresh_token
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'name'], 'required'],
            [['username', 'password', 'name', 'token'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['token'], 'unique'],
            [['refresh_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Nome de usuário',
            'password' => 'Senha',
            'name' => 'Nome',
            'token' => 'Token',
            'refresh_token' => 'Refresh token',
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        // remove fields that contain sensitive information
        unset($fields['password']);
        unset($fields['token']);
        unset($fields['refresh_token']);

        return $fields;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->token;
    }

    public function validateAuthKey($token)
    {
        return $this->token === $token;
    }
}