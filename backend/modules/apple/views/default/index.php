<?php

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

            'apple_id',
            'user_id',
            'color',
            'status',
            'integrity',
            'drop_at',
            'created_at',
            'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
