<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model caritor\cms\models\CmsPages */

$this->title = 'Create Cms Pages';
$this->params['breadcrumbs'][] = ['label' => 'Cms Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-pages-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
