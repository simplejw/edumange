<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "edu_order_goods".
 *
 * @property int $rec_id 订单记录编号（自增id）
 * @property int $order_id 订单商品信息对应的详细信息id，取值order_info的order_id
 * @property int $user_id 用户id
 * @property int $cat_id 所属分类
 * @property int $product_id 生产编号
 * @property string $goods_sn 商品的唯一货号，取值ecs_goods
 * @property string $goods_name 商品的名称，取值表ecs_goods
 * @property string $attr_value 商品规格
 * @property string $goods_img 商品缩略图
 * @property string $goods_price 商品的本店售价，取值product
 * @property int $goods_number 商品的购买数量
 * @property int $is_delete 是否删除 0未删除 1已删除
 * @property string $last_update_time 最后更新时间
 */
class OrderGoods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'edu_order_goods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id', 'cat_id', 'product_id', 'goods_number', 'is_delete'], 'integer'],
            [['goods_price'], 'number'],
            [['last_update_time'], 'safe'],
            [['goods_sn'], 'string', 'max' => 20],
            [['goods_name'], 'string', 'max' => 120],
            [['attr_value', 'goods_img'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'rec_id' => 'Rec ID',
            'order_id' => 'Order ID',
            'user_id' => 'User ID',
            'cat_id' => 'Cat ID',
            'product_id' => 'Product ID',
            'goods_sn' => 'Goods Sn',
            'goods_name' => 'Goods Name',
            'attr_value' => 'Attr Value',
            'goods_img' => 'Goods Img',
            'goods_price' => 'Goods Price',
            'goods_number' => 'Goods Number',
            'is_delete' => 'Is Delete',
            'last_update_time' => 'Last Update Time',
        ];
    }
}
