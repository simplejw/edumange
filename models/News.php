<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "edu_news".
 *
 * @property int $news_id 自增ID
 * @property string $title 新闻标题
 * @property string $thumb 新闻头图
 * @property string $content 新闻内容
 * @property int $is_delete 是否删除 0未删除 1已删除
 * @property string $last_update_time 最后更新时间
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'edu_news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['content'], 'string'],
            [['is_delete'], 'integer'],
            [['last_update_time'], 'safe'],
            [['title', 'thumb'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'news_id' => 'News ID',
            'title' => 'Title',
            'thumb' => 'Thumb',
            'content' => 'Content',
            'is_delete' => 'Is Delete',
            'last_update_time' => 'Last Update Time',
        ];
    }
}
