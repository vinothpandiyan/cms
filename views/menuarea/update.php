<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model caritor\cms\models\CmsMenuArea */

$this->title = 'Update Cms Menu Area: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Cms Menu Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->area_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cms-menu-area-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
