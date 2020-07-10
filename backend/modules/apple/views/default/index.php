<?php

use common\models\Apples;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = 'Apples';
$this->params['breadcrumbs'][] = $this->title;
\app\modules\apple\assets\AppleAsset::register($this);
?>
<div class="apples-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Apples', ['create'], ['class' => 'btn btn-success', 'id' => 'apples_create']) ?>
    <div class="spinner-border" role="status" style="display: none">
        <span class="sr-only"></span>
    </div>
    </p>

    <?php Pjax::begin(['id' => 'apple_grid']); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            'color',
            [
                'attribute' => 'status',
                'value'     => function (Apples $model) {
                    return Apples::$STATUS[$model->status];
                }
            ],
            [
                'attribute' => 'size',
                'value'     => function (Apples $model) {
                    return $model->size . ' %';
                }
            ],
            [
                'attribute' => 'drop_at',
                'value'     => function (Apples $model) {
                    return Yii::$app->formatter->asRelativeTime($model->drop_at);
                },
                'format'    => 'html'
            ],
            [
                'attribute' => 'created_at',
                'value'     => function (Apples $model) {
                    return Yii::$app->formatter->asRelativeTime($model->created_at);
                }
            ],
            'updated_at',

            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{drop} {eat} {delete}',
                'buttons'  => [
                    'drop'   => function ($url, $model, $key) {
                        return Html::a('Уронить', $url, [
                            'title'   => 'Уронить яблоко с дерева',
                            'class'   => 'btn btn-secondary btn-sm btn_drop',
                            'data-id' => $model->apple_id
                        ]);
                    },
                    'eat'    => function ($url, $model, $key) {
                        return Html::a('Съесть', $url, [
                            'title'   => 'Откусить часть яблока',
                            'class'   => 'btn btn-primary btn-sm btn_eat',
                            'data-id' => $model->apple_id
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('Удалить', $url, [
                            'title'   => 'Удалить',
                            'class'   => 'btn btn-danger btn-sm btn_delete',
                            'data-id' => $model->apple_id
                        ]);
                    },
                ]
            ]
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
