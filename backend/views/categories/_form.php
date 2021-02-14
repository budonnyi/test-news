<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Categories */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categories-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent_category_id')->dropDownList(
            \yii\helpers\ArrayHelper::merge([0 => '- root category -'],
            \yii\helpers\ArrayHelper::map(\common\models\Categories::findAll(['status' => 1]), 'id', 'title'))
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
