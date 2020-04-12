<?php

namespace app\models;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $authKey;
//    public $accessToken;

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
//        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
        $admin = AdminUser::find()->where(['user_id' => $id, 'is_delete' => NOT_DELETE_0])->one();
        if ($admin === null) {
            return null;
        }

        $tmpAdmin['id'] = $admin->user_id;
        $tmpAdmin['username'] = $admin->user_name;
        $tmpAdmin['password'] = $admin->password;
        $tmpAdmin['authKey']  = $admin->auth_key;
        return new static($tmpAdmin);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $admin = AdminUser::find()->where(['user_name' => $username, 'is_delete' => NOT_DELETE_0])->one();
        if ($admin === null) {
            return null;
        }

        $tmpAdmin['id'] = $admin->user_id;
        $tmpAdmin['username'] = $admin->user_name;
        $tmpAdmin['password'] = $admin->password;
        $tmpAdmin['authKey']  = $admin->auth_key;
        return new static($tmpAdmin);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

}
