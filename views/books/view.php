<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Books $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="books-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            'year_of_publication',
            'isbn',
            [
                    'attribute' => 'cover',
                    'label' => 'Обложка',
                    'format' => ['image',['width'=>'100','height'=>'100']],
                    'value' => '/uploads/' . $model->cover
            ],
            [
                'label' => 'Авторы',
                'value' => function($model) {
                    $out = [];
                    foreach ($model->authorBooks as $a) {
                        $out []= $a->author->getFio();
                    }
                    return implode(', ', $out);
                },
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
