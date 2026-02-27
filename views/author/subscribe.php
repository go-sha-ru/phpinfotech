<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Subscriptions $model */
/** @var app\models\Author $author */

$this->title = 'Подписаться на автора ' . $author->getFIO();
$this->params['breadcrumbs'][] = ['label' => 'Авторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('subscribe_form', [
        'model' => $model,
    ]) ?>

</div>
