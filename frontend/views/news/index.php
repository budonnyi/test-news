<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>

<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-3">
                <h2>Categories</h2>
                <?= $html ?? '' ?>
            </div>

            <div class="col-lg-9">
                <?php if(!empty($newsList)) { ?>
                <?php foreach ($newsList as $new) { ?>
                    <h2><?= $new->title ?></h2>
                    <p><?= $new->text ?></p>
                    <p>This new in categories:</p>
                    <?php foreach ($new->categories as $category) { ?>
                        <a href="<?= \yii\helpers\Url::to(['/news/index', 'category_id' => $category->category_id]) ?>"><?= $category->category->title ?></a>
                    <?php } ?>
                    <hr>
                <?php } ?>
                <?php } else { ?>
                    <h2>There is no any news</h2>
                <?php } ?>

            </div>

        </div>

    </div>
</div>


