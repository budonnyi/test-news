<?php

namespace frontend\controllers;

use common\models\News;
use yii\rest\ActiveController;
use yii\web\ServerErrorHttpException;

class ApiController extends ActiveController
{
    public $modelClass = 'common\models\News';

    public function actionNews($category_id)
    {
        if ($newsList = News::find()->where(['news_to_category.category_id' => $category_id])->joinWith(['categories'])->all()) {
            return $newsList;
        }

        throw new ServerErrorHttpException("Can't find this category in database");
    }
}
