<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel caritor\cms\models\CmsMenuAreaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cms Menu Areas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-menu-area-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cms Menu Area', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'area_id',
            'name',
            'area_code',
            [
                'attribute' => 'created_by',
                'value' => 'createdBy.username',
                'filter' => true
            ],          
            [
                'attribute' => 'status',
                'value' => function($model){
                    return $model->status == 1 ? '<span class="label label-success">Enabled</span>
' : '<span class="label label-danger">Disabled</span>';
                },
                'format' => 'html',
                'filter' => Html::activeDropDownList($searchModel, 'status', ['1' => 'Enabled', '0' => 'Disabled'],['class'=>'form-control','prompt' => 'Select Status']),           
            ],
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
