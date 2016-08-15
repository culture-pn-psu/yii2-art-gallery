<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\artGallery\models\ArtJob */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('art', 'ผลงานทั้งหมด'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='box box-info'>
    <div class='box-header'>
        <h3 class='box-title'><?= Html::encode($this->title) ?></h3>

        <div class="box-tools">
            <?= Html::a(Yii::t('art', 'PDF'), ['pdf', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

            <?= Html::a(Yii::t('art', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

            <?=
            Html::a(Yii::t('art', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('art', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ])
            ?>
        </div>
    </div><!--box-header -->

    <div class='box-body pad'>
        <div class='row'>
            <div class='col-sm-3' >
                <?= Html::img($model->imgTemp, ['class' => 'thumbnail', 'width' => '100%']) ?> 
            </div>
            <div class='col-sm-9'>
                <div class='row'>
                    <?= dosamigos\gallery\Gallery::widget(['items' => $model->getThumbnails()]); ?>
                </div>


                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        //'image_id',
                        'art_code',
                        'title',
                        [
                            'attribute' => 'artist_id',
                            'format' => 'raw',
                            'value' => $model->artist->displaynameImg
                        ],
                        [
                            'attribute' => 'size',
                            'value' => $model->sizeUnit
                        ],
                        'concept:ntext',
                        'artType.title',
                        'artTechnique.title',
                        //'artist',
                        'status',
                        'note:ntext',                        
                    ],
                ]);
                ?>                             
            </div><!--box-body pad-->
        </div><!--box-body pad-->
    </div><!--box-body pad-->
</div><!--box-body pad-->
</div><!--box box-info-->
