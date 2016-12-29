<?php

namespace culturePnPsu\artGallery;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'culturePnPsu\artGallery\controllers';

    public function init()
    {
        $this->layout = 'left-menu.php';
        parent::init();

        // custom initialization code goes here
    }
}
