<?php

namespace backend\modules\artGallery;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\artGallery\controllers';

    public function init()
    {
        $this->layout = 'left-menu.php';
        parent::init();

        // custom initialization code goes here
    }
}
