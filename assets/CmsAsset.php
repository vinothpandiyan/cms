<?php
namespace caritor\cms\assets;

use yii\web\AssetBundle;

/**
 * This declares the asset files required by CMS.
 *
 * @author Vinoth Pandiyan <vinoth.p@caritorsolutions.com>
 */
class CmsAsset extends AssetBundle
{
    // the alias to assets folder in file system
    public $sourcePath = '@vendor/caritor/yii2-cms/assets/source';
    public $css = ['css/cms_menu.css'];
    public $js = [
      'js/jquery.nestable.js',
      'js/cms.menu.js',
    ];
    // that are the dependecies, for making Asset bundle work with Yii2 framework
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}