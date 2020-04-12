<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "edu_product".
 *
 * @property int $product_id 产品编号
 * @property string $goods_name 课程名
 * @property string $goods_sn 货号
 * @property string $goods_link 课程地址
 * @property string $goods_img 头图
 * @property string $goods_desc 详细描述
 * @property string $goods_price 具体价格
 * @property int $cat_id 分类编号
 * @property int $scat_id 二级分类
 * @property string $attr_value SKU属性
 * @property string $tech_name 讲师名称
 * @property string $tech_icon 讲师头像
 * @property string $tech_position 讲师职位
 * @property int $sort_order 排序
 * @property int $is_delete 是否删除 0未删除 1已删除
 * @property string $last_update_time 最后更新时间
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'edu_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['goods_desc'], 'required'],
            [['goods_desc'], 'string'],
            [['goods_price'], 'number'],
            [['cat_id', 'scat_id', 'sort_order', 'is_delete'], 'integer'],
            [['last_update_time'], 'safe'],
            [['goods_name'], 'string', 'max' => 120],
            [['goods_sn', 'attr_value'], 'string', 'max' => 20],
            [['goods_link', 'tech_icon', 'tech_position'], 'string', 'max' => 255],
            [['goods_img', 'tech_name'], 'string', 'max' => 100],
            [['goods_sn'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'goods_name' => 'Goods Name',
            'goods_sn' => 'Goods Sn',
            'goods_link' => 'Goods Link',
            'goods_img' => 'Goods Img',
            'goods_desc' => 'Goods Desc',
            'goods_price' => 'Goods Price',
            'cat_id' => 'Cat ID',
            'scat_id' => 'Scat ID',
            'attr_value' => 'Attr Value',
            'tech_name' => 'Tech Name',
            'tech_icon' => 'Tech Icon',
            'tech_position' => 'Tech Position',
            'sort_order' => 'Sort Order',
            'is_delete' => 'Is Delete',
            'last_update_time' => 'Last Update Time',
        ];
    }
}
