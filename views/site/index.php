<?php

/** @var yii\web\View $this */
/** @var $dataProvider */
/** @var array $years */
/** @var string $year */
/** @var app\models\Books $model */

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->title = 'Отчёт';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-6">Отчет - ТОП 10 авторов, выпустившие больше книг за <?php echo $year?></h1>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4 mb-3">
                <?php
                Pjax::begin(['id' => 'Books[year_of_publication]']);
                $form = ActiveForm::begin(['options' => ['data-pjax' => true ]]);
                echo $form->field($model, 'year_of_publication')->dropDownList(
                        ArrayHelper::map($years, 'year_of_publication', 'year_of_publication'),
                        ['options'=>[$year => ['Selected'=>true]]]
                );
                echo Html::submitButton('Искать');
                ActiveForm::end();
                Pjax::end();
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 mb-3">
                <?php
                Pjax::begin(['id' => 'books']);
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'last_name',
                            'label' => 'Фамилия',
                        ],
                        [
                            'attribute' => 'first_name',
                            'label' => 'Имя',
                        ],
                        [
                            'attribute' => 'patronymic_name',
                            'label' => 'Отчество',
                        ],
                        [
                            'attribute' => 'title',
                            'label' => 'Название книги',
                        ],
                    ]
                ]);
                Pjax::end();
                ?>
            </div>
        </div>

    </div>
</div>
<?php $this->registerJs(
    '$("document").ready(function(){ 
		$("#year_of_publication").on("pjax:end", function() {
			$.pjax.reload({container:"#books"});
		});
    });'
)
    ?>
