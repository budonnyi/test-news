<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['maxlength' => true]) ?>

    <?= $form->field($modelNewsToCategory, 'category_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\common\models\Categories::findAll(['status' => 1]), 'id', 'title'), ['prompt' => 'Choise the category...', 'multiple'=>'multiple']
    ) ?>

    <?= $form->field($model, 'status')->dropDownList([
        1 => 'Shown',
        0 => 'Hidden'
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
