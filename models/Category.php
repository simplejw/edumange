<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "edu_category".
 *
 * @property int $cat_id 分类编号
 * @property int $parent_id 父级分类
 * @property string $cat_name 分类名称
 * @property string $cat_img 分类头图URL
 * @property int $sort_order 楼层顺序
 * @property int $is_delete 是否删除 0未删除 1已删除
 * @property string $last_update_time 最后更新时间
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'edu_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'sort_order', 'is_delete'], 'integer'],
            [['last_update_time'], 'safe'],
            [['cat_name'], 'string', 'max' => 60],
            [['cat_img'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cat_id' => 'Cat ID',
            'parent_id' => 'Parent ID',
            'cat_name' => 'Cat Name',
            'cat_img' => 'Cat Img',
            'sort_order' => 'Sort Order',
            'is_delete' => 'Is Delete',
            'last_update_time' => 'Last Update Time',
        ];
    }
}
