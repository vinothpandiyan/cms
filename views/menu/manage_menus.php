<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $
common\modules\cms\models\CmsMenu */
/* @var $form yii\widgets\ActiveForm */
// here comes your Yii2 asset's class!
use caritor\cms\assets\CmsAsset;
CmsAsset::register($this);
?>

<div class="row">
    <h4 align="center">Step 2 : Manage Menu Items</h4>
    <div class="col-lg-4 grey-border">
        <h4>CMS pages</h4>
        <?php foreach($cms_pages as $page){ ?>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="cms_page[<?= $page['page_id'] ?>]" data-name="<?= $page['menu_title'] ?>" data-id="<?= $page['page_id'] ?>" value="<?= $page['menu_title'] ?>">
                <?= $page['menu_title']; ?>
            </label>
        </div> 
        <?php } ?>
        <button class="addmenu btn btn-primary">Add To Menu</button>           
    </div>
    <div class="col-lg-8">
        <div class="main-box-body clearfix">
            <div id="nestable-menu">
                <button type="button" class="btn btn-primary" data-action="expand-all">Expand All</button>
                <button type="button" class="btn btn-danger" data-action="collapse-all">Collapse All</button>
            </div>

            <div class="ajax-messages">
                
            </div>

            <div class="row cf nestable-lists">

                <div class="col-md-6 dd" id="nestable">
                    <ol class="dd-list initmenu">
                        <?php if(count($model) > 0) { ?>
                        <?php foreach($model as $menu) { ?>
                        <?php if($menu['menu_status'] == 1) { ?>
                        <li class="dd-item" data-id="<?= $menu['menu_id'] ?>" data-pageid="<?= $menu['page_id'] ?>">    
                            <button class='dd-action pull-right' type='button'  data-action='remove' title='Remove'><i class='icon-remove'></i></button>
                            <div class="dd-handle">
                                <?= $menu['menu_title'] ?>
                            </div>
                            <?php if(count($menu['children']) > 0) { ?>
                            <ol class="dd-list">
                                <?php foreach($menu['children'] as $children) { ?>
                                <?php if($children['menu_status'] == 1) { ?>
                                    <li class="dd-item" data-id="<?= $children['menu_id'] ?>" data-pageid="<?= $children['page_id'] ?>">
                                        <button class='dd-action pull-right' type='button' data-action='remove' title='Remove'><i class='icon-remove'></i></button>
                                        <div class="dd-handle">
                                            <?= $children['menu_title'] ?>
                                        </div>
                                        <?php if(count($children['children']) > 0) { ?>
                                            <ol class="dd-list">
                                                <?php foreach($children['children'] as $sub_children) { ?>
                                                <?php if($sub_children['menu_status'] == 1) { ?>
                                                    <li class="dd-item dd-nonest" data-id="<?= $sub_children['menu_id'] ?>" data-pageid="<?= $sub_children['page_id'] ?>">
                                                        <button class='dd-action pull-right' type='button' data-action='remove' title='Remove'><i class='icon-remove'></i></button>
                                                        <div class="dd-handle">                           
                                                            <?= $sub_children['menu_title'] ?>
                                                        </div>
                                                    </li>
                                                <?php } ?>
                                                <?php } ?>
                                            </ol>
                                        <?php } ?>
                                    </li>
                                    <?php } ?>
                                <?php } ?>
                            </ol>
                            <?php } ?>
                        </li>
                        <?php } ?>
                        <?php } ?>
                        <?php } ?>
                    </ol>
                </div>
            </div>

            <?php $form = ActiveForm::begin(['id' => 'menu-update','action' => ['savemenu']]); ?>
                <div>
                    <?= Html::a('Select Another Area', ['/cms/menu/selectarea'], ['class'=>'btn btn-primary']) ?>
                    <button type="button" class="btn btn-danger update-menu">Update Menu</button>
                </div>
                <input type="hidden" name="area_id" value="<?= $area_id ?>">
                <input type="hidden" id="nestable-output" name="menu_json" value="" />
            <?php ActiveForm::end(); ?>

        </div>
        <!-- Nested lists ends -->
    </div>
</div>