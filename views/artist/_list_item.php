<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
    <a class="thumbnail fancybox" rel="ligthbox" href="<?= Url::to(['/art-gallery/default/view', 'id' => $model->id]) ?>">
        <div  style="float: left;overflow: hidden;height: 200px;display: block;width: 100%;margin-bottom: 5px;border-bottom: 1px solid #eee;background: #eee;">
            <?= Html::img($model->imgTemp, [ 'width' => '100%', 'class' => 'center-block img-responsive']) ?>
        </div>
        <div class='text-right' style="margin:5px 5px 15px 5px;">
            <?=Html::tag('h4',$model->title,['style'=>'margin-bottom:0px;']) ?>
            <small class='text-muted'>
                <?=$model->artType->title. '/'.$model->artTechnique->title.'<br/>'.$model->sizeUnitShort;?>
            </small>            
        </div> <!-- text-right / end -->
    </a>
</div> <!-- col-6 / end -->

