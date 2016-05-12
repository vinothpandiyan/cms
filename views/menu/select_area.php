<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $
 common\modules\cms\models\CmsMenu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cms-menu-form">

    <h4 align="center">Step 1 : Pick Menu Area To Manage</h4>

    <?php $form = ActiveForm::begin([
        'method' => 'POST',
        'action' => ['managemenu']
    ]); ?>

    <?= $form->field($model, 'area_id')->dropDownList(ArrayHelper::map($items, 'area_id', 'name'),['prompt' => 'please select area'])->label('Menu Area'); ?>

    <div class="form-group">
        <?= Html::submitButton('Manage', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
