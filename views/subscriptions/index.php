<?php

use yii\helpers\Html;
use yii\grid\GridView;


/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Подписки';
$this->params['breadcrumbs'][] = $this->title;

?>
    <h1><?= Html::encode($this->title) ?></h1>

<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'phone',
        [
            'label' => 'Автор',
            'value' => function($data) {
                return $data->author->getFIO();
            }
        ]
    ]
    ])
?>