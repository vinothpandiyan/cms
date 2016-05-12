<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model caritor\cms\models\CmsMenuArea */

$this->title = 'Create Cms Menu Area';
$this->params['breadcrumbs'][] = ['label' => 'Cms Menu Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-menu-area-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
