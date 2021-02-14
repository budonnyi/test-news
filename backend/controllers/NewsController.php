<?php

namespace backend\controllers;

use common\models\NewsToCategory;
use Yii;
use common\models\News;
use common\models\NewsSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single News model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new News();
        $modelNewsToCategory = new NewsToCategory();

        if ($model->load($request = Yii::$app->request->post()) && $model->save()) {
            $modelNewsToCategory->load($request);

            foreach ($modelNewsToCategory->category_id as $category_id) {
                $newsModel = new NewsToCategory();
                $newsModel->news_id = $model->id;
                $newsModel->category_id = $category_id;
                $newsModel->save();
            }
            return $this->redirect('index');
        }


        return $this->render('create', [
            'model' => $model,
            'modelNewsToCategory' => $modelNewsToCategory,
        ]);
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelNewsToCategory = new NewsToCategory();

        $categoriesArray = ArrayHelper::getColumn(NewsToCategory::findAll(['news_id' => $id]), 'category_id');
        $modelNewsToCategory->category_id = $categoriesArray;
        
        if ($model->load($request = Yii::$app->request->post()) && $model->save()) {
            NewsToCategory::deleteAll(['news_id' => $id]);
            $modelNewsToCategory->load($request);

            foreach ($modelNewsToCategory->category_id as $category_id) {
                $newsModel = new NewsToCategory();
                $newsModel->news_id = $model->id;
                $newsModel->category_id = $category_id;
                $newsModel->save();
            }
            return $this->redirect('index');
        }


        return $this->render('update', [
            'model' => $model,
            'modelNewsToCategory' => $modelNewsToCategory
        ]);
    }

    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
