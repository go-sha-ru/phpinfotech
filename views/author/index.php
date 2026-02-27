<?php

use app\models\Author;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Authors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Author', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'first_name',
            'last_name',
            'patronymic_name',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Author $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{subscribe}',
                'buttons' => [
                    'subscribe' => function ($url, $model) {
                        return Html::a('<span class="btn btn-primary">Подписаться</span>', $url,
                            [
                                'title' => 'Подписаться',
                            ]);
                    }
                ],
                'urlCreator' => function ($action, Author $model, $key, $index) {
                    if ($action === 'subscribe') {
                        return Url::to(['author/subscribe', 'id' => $model->id]);
                    }
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
