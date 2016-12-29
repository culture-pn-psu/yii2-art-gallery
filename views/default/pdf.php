<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
?>
<table border='0' style="width:100%;">
    <tr>
        <td style="max-width:140px;" class="text-center" valign='top'>

            <?= Html::img($model->imgTemp, ['class' => '', 'style' => 'max-width:140px;']) ?>  
            <?= Html::tag('h4', 'ภาพผลงาน') ?>
        </td>
        <td style="padding:0 10px;"  valign='top' class="text-nowrap">
            <?=
            DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table', 'border' => "0"],
                'template' => '<tr><th class="text-right text-nowrap" width="80" style="font-size:16px">{label}&nbsp;&nbsp;</th><td style="font-size:16px" class="text-left text-nowrap">&nbsp;&nbsp;{value}</td></tr>',
                'attributes' => [
                    //'image_id',
                    'art_code',
                    'title',
                    [
                        'attribute' => 'artist_id',
                        'value' => $model->artist->fullname
                    ],
                    [
                        'attribute' => 'size',
                        'value' => $model->sizeUnit
                    ],
                    [
                        'label' => $model->artType->getAttributeLabel('title') . '/' . $model->artTechnique->getAttributeLabel('title'),
                        'value' => implode('/', [$model->artType->title, $model->artTechnique->title])
                    ],
                    'concept:ntext',
                    'note:ntext',
                ],
            ]);
            ?>
        </td>
        <td style="max-width:140px;" class="text-center" valign='top'>
            <?= Html::img($model->qrcode, ['width' => '120']) ?>  
            <?= Html::tag('h4', 'ID:'.$model->id) ?>
        </td>
    </tr>
</table>
<hr style="margin:0 0 15px 0px;"/>

