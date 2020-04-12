<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "edu_order_info".
 *
 * @property int $order_id 订单编号（自增id）
 * @property string $order_sn 订单序列号
 * @property int $user_id 用户id,同ecs_users的user_id
 * @property int $gender 性别 ; 0保密; 1男; 2女
 * @property string $realname 收货人的姓名,用户页面填写,默认取值表user_address
 * @property int $political_status 政治面貌：0群众 1团员 2党员
 * @property string $address 收货人的详细地址,用户页面填写,默认取值于表user_address
 * @property string $mobile 收货人的手机,用户页面填写,默认取值于表user_address
 * @property string $email 收货人的Email, 用户页面填写,默认取值于表user_address
 * @property string $remark 订单留言
 * @property string $order_amount 应付款金额
 * @property int $order_status 订单的状态;0未确认,1确认,2已取消
 * @property int $pay_status 支付状态;0未付款;1付款中;2已付款;3已退款
 * @property string $add_time 订单生成时间
 * @property string $confirm_time 订单确认时间
 * @property string $pay_time 订单支付时间
 * @property int $is_delete 是否删除 0未删除 1已删除
 * @property string $last_update_time 最后更新时间
 */
class OrderInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'edu_order_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'gender', 'political_status', 'order_status', 'pay_status', 'is_delete'], 'integer'],
            [['order_amount'], 'number'],
            [['add_time', 'confirm_time', 'pay_time', 'last_update_time'], 'safe'],
            [['order_sn'], 'string', 'max' => 20],
            [['realname'], 'string', 'max' => 120],
            [['address', 'remark'], 'string', 'max' => 255],
            [['mobile', 'email'], 'string', 'max' => 60],
            [['order_sn'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'order_sn' => 'Order Sn',
            'user_id' => 'User ID',
            'gender' => 'Gender',
            'realname' => 'Realname',
            'political_status' => 'Political Status',
            'address' => 'Address',
            'mobile' => 'Mobile',
            'email' => 'Email',
            'remark' => 'Remark',
            'order_amount' => 'Order Amount',
            'order_status' => 'Order Status',
            'pay_status' => 'Pay Status',
            'add_time' => 'Add Time',
            'confirm_time' => 'Confirm Time',
            'pay_time' => 'Pay Time',
            'is_delete' => 'Is Delete',
            'last_update_time' => 'Last Update Time',
        ];
    }
}
