<?php

use yii\helpers\Html;
use caritor\cms\models\CmsMenuArea;


/* @var $this yii\web\View */
/* @var $model caritor\cms\models\CmsMenu */

$this->title = 'Manage Menu';
$this->params['breadcrumbs'][] = ['label' => 'Manage Menu', 'url' => ['selectarea']];
// $this->params['breadcrumbs'][] = ['label' => $model->menu_id, 'url' => ['view', 'id' => $model->menu_id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="cms-menu-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('select_area', [
        'model' => $model,
        'items' => CmsMenuArea::find()->select(['area_id','name'])->where(['status' => '1'])->asArray()->all()
    ]) ?>

</div>