<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "edu_region".
 *
 * @property int $region_id 地区编号（自增id）
 * @property int $parent_id 该地区父节点的地区编号
 * @property string $region_name 地区名
 * @property string $region_postcode 邮编
 * @property int $region_type 地区类型 1省 2地级市 3区/县
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'edu_region';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'region_type'], 'integer'],
            [['region_name'], 'string', 'max' => 120],
            [['region_postcode'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'region_id' => 'Region ID',
            'parent_id' => 'Parent ID',
            'region_name' => 'Region Name',
            'region_postcode' => 'Region Postcode',
            'region_type' => 'Region Type',
        ];
    }
}
