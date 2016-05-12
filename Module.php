<?php

namespace caritor\cms;

/**
 * cmsbackend module definition class
 */
class cms extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'caritor\cms\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // $this->setAliases([
        //     '@cms-assets' => __DIR__ . '/assets'
        // ]);

        // // custom initialization code goes here
    }
}
