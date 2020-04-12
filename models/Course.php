<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "edu_course".
 *
 * @property int $course_id ID
 * @property int $cat_id edu_category 自增ID
 * @property int $product_id 取自product的 product_id
 * @property string $vod_id 阿里云点播视频ID
 * @property string $cs_name 课程名
 * @property string $cs_desc 课程简介
 * @property string $cs_link 课程视频地址
 * @property int $cs_count 点击数
 * @property int $sort 课程排序
 * @property int $is_delete 是否删除 0：未删除 1：已删除
 * @property string $last_update_time 最后更新时间
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'edu_course';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cat_id', 'product_id', 'cs_count', 'sort', 'is_delete'], 'integer'],
            [['cs_desc'], 'required'],
            [['cs_desc'], 'string'],
            [['last_update_time'], 'safe'],
            [['vod_id', 'cs_name'], 'string', 'max' => 255],
            [['cs_link'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'course_id' => 'Course ID',
            'cat_id' => 'Cat ID',
            'product_id' => 'Product ID',
            'vod_id' => 'Vod ID',
            'cs_name' => 'Cs Name',
            'cs_desc' => 'Cs Desc',
            'cs_link' => 'Cs Link',
            'cs_count' => 'Cs Count',
            'sort' => 'Sort',
            'is_delete' => 'Is Delete',
            'last_update_time' => 'Last Update Time',
        ];
    }
}
