<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "edu_identity_image".
 *
 * @property int $id 自增ID
 * @property int $user_id 用户id,同ecs_users的user_id
 * @property int $order_id 关联order_info表的order_id
 * @property string $identity_fr 身份证正面照
 * @property string $identity_bg 身份证反面照
 * @property string $edu_img 学历照
 * @property string $signage_img 2寸白底照片
 * @property int $is_delete 是否删除 0未删除 1已删除
 * @property string $last_update_time 最后更新时间
 */
class IdentityImage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'edu_identity_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'order_id', 'is_delete'], 'integer'],
            [['last_update_time'], 'safe'],
            [['identity_fr', 'identity_bg', 'edu_img', 'signage_img'], 'string', 'max' => 255],
            [['order_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'order_id' => 'Order ID',
            'identity_fr' => 'Identity Fr',
            'identity_bg' => 'Identity Bg',
            'edu_img' => 'Edu Img',
            'signage_img' => 'Signage Img',
            'is_delete' => 'Is Delete',
            'last_update_time' => 'Last Update Time',
        ];
    }
}
