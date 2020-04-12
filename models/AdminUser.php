<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "edu_admin_user".
 *
 * @property int $user_id 管理员编号（自增id号）
 * @property string $user_name 管理员登录名
 * @property string $email 管理员邮箱
 * @property string $password 管理员登录密码
 * @property string $auth_key login key
 * @property string $add_time 管理员添加时间
 * @property string $last_login 管理员最后一次登录时间
 * @property string $last_ip 管理员最后一次登录IP
 * @property int $role_id 登录用户的角色编号
 * @property string $last_update_time 最后更新时间
 * @property int $is_delete 是否删除 0未删除 1已删除
 */
class AdminUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'edu_admin_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['add_time', 'last_login', 'last_update_time'], 'safe'],
            [['role_id', 'is_delete'], 'integer'],
            [['user_name', 'email'], 'string', 'max' => 60],
            [['password'], 'string', 'max' => 100],
            [['auth_key'], 'string', 'max' => 300],
            [['last_ip'], 'string', 'max' => 15],
            [['user_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'user_name' => 'User Name',
            'email' => 'Email',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'add_time' => 'Add Time',
            'last_login' => 'Last Login',
            'last_ip' => 'Last Ip',
            'role_id' => 'Role ID',
            'last_update_time' => 'Last Update Time',
            'is_delete' => 'Is Delete',
        ];
    }
}
