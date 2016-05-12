<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel caritor\cms\models\CmsPagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cms Pages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-pages-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create New', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'menu_title',
            [
                'attribute' => 'created_by',
                'value' => 'createdBy.username'
            ],
            [
                'attribute'=> 'created_at',
                'value' => 'created_at',
                'filter' => false
            ],
            [
                'attribute'=> 'updated_at',
                'value' => 'created_at',
                'filter' => false
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model->status == 1 ? '<span class="label label-success">Enabled</span>
' : '<span class="label label-danger">Disabled</span>';
                },
                'format' => 'html',
                'filter' => Html::activeDropDownList($searchModel, 'status', ['1' => 'Enabled', '0' => 'Disabled'],['class'=>'form-control','prompt' => 'Select Status']),
            ],

            ['class' => 'yii\grid\ActionColumn'],

            
        ],
    ]); ?>
</div>
