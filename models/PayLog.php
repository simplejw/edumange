<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "edu_pay_log".
 *
 * @property int $log_id 支付记录编号（自增id）
 * @property int $order_id 对应的交交易记录的id,取值表ecs_order_info
 * @property string $out_trade_no 订单号
 * @property string $order_amount 支付金额
 * @property int $pay_type 支付方式 0微信
 * @property string $trade_no 支付流水号
 * @property int $is_paid 是否已支付,0否;1是
 */
class PayLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'edu_pay_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'pay_type', 'is_paid'], 'integer'],
            [['order_amount'], 'number'],
            [['out_trade_no'], 'string', 'max' => 100],
            [['trade_no'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'log_id' => 'Log ID',
            'order_id' => 'Order ID',
            'out_trade_no' => 'Out Trade No',
            'order_amount' => 'Order Amount',
            'pay_type' => 'Pay Type',
            'trade_no' => 'Trade No',
            'is_paid' => 'Is Paid',
        ];
    }
}
