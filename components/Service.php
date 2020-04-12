<?php

namespace app\components;

use Yii;

use app\models\Region;
use app\models\Category;

class Service
{
    /**
     * 区域信息 (省 市 区)
     * @return array
     */
    public static function region()
    {
        $key = 'region';

        $region = Yii::$app->cache->get($key);

        if(empty($region))
        {
            $region = array();

            $_region = Region::find()->where(['<=', 'region_type', 3])
                ->all();
            if(!empty($_region))
            {
                foreach($_region as $v)
                {
                    $region[$v->region_id] = $v->attributes;
                }

                Yii::$app->cache->set($key, $region, 600);
            }
        }

        return $region;
    }

    public static function address($province = 0, $city = 0, $district = 0)
    {
        $address = '';

        $region = Service::region();
        if($province && $city && $district && !empty($region))
        {
            $address = $region[$province]['region_name'] . ',' .$region[$city]['region_name'] . ','. $region[$district]['region_name'] . ',';
        }

        return $address;
    }

    public static function category()
    {
        $category = [];

        $_category = Category::find()->where(['is_delete' => 0])->all();
        if(!empty($_category))
        {
            foreach($_category as $v)
            {
                $category[$v->cat_id] = $v->attributes;
            }
        }

        return $category;
    }

    public static function createGoodsNum()
    {
        return time() . mt_rand(100, 999);
    }

    public static function createOrderNum()
    {
        return time() . mt_rand(100, 999);
    }

}
