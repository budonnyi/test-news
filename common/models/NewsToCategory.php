<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "news_to_category".
 *
 * @property int $id
 * @property int|null $news_id
 * @property int|null $category_id
 */
class NewsToCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_to_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['news_id', 'safe'],
            ['category_id', 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'news_id' => 'News ID',
            'category_id' => 'Category ID',
        ];
    }

    public function getNews()
    {
        return $this->hasMany(News::className(), ['id' => 'news_id']);
    }

    public function getNew()
    {
        return $this->hasOne(News::className(), ['id' => 'news_id']);
    }

    public function getCategories()
    {
        return $this->hasMany(Categories::className(), ['id' => 'category_id']);
    }

    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }
}
