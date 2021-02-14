<?php

namespace frontend\controllers;

use common\models\Categories;
use common\models\News;
use common\models\NewsToCategory;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class NewsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($category_id = 1)
    {
        $categories = ArrayHelper::index(Categories::find()->where(['status' => 1])->asArray()->all(), 'id');
        $tree = $this->getTree($categories);
        $html = $this->getMenuHtml($tree);

        $newsList = News::find()->where(['news_to_category.category_id' => $category_id])->joinWith(['categories'])->all();

        return $this->render('index', [
            'html' => $html,
            'newsList' => $newsList
        ]);
    }

    // recursively make the catalog tree
    public function getTree($categories)
    {
        $tree = [];

        foreach ($categories as $id => &$node) {
            if (!$node['parent_category_id'])
                $tree[$id] = &$node;
            else
                $categories[$node['parent_category_id']]['childs'][$node['id']] = &$node;
        }

        return $tree;
    }

    public function getMenuHtml($tree)
    {
        $str = '';
        foreach ($tree as $category) {
            $str .= $this->buildMenu($category);
        }

        return $str;
    }

    protected function buildMenu($category)
    {
        $html = "<li>" .
            '<a href="/news/index?category_id=' . $category['id'] . '">' . $category['title'] . "</a>";

        if (isset($category['childs'])) {
            $html .= "<ul class=''>";
            $html .= $this->getMenuHtml($category['childs']);
            $html .= "</ul>";
        }

        $html .= "</li >";

        return $html;
    }
}
