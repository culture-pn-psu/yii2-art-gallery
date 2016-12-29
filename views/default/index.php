<?php

use yii\helpers\Html;
use yii\grid\GridView;
use culturePnPsu\artGallery\models\Artist;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel culturePnPsu\artGallery\models\ArtJobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('art', 'ผลงานศิลปะ');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='box box-info'>
    <div class='box-header'>
        <h3 class='box-title'><?= Html::encode($this->title) ?></h3>
        <div class="box-tools">
            <?= Html::a('<i class="fa fa-file-pdf-o"></i>', ['pdf'], ['id' => 'btn-pdf', 'class' => 'btn btn-primary']) ?>
        </div>
    </div><!--box-header -->

    <div class='box-body pad'>


        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [

                ['class' => 'yii\grid\SerialColumn'],
                ['class' => 'yii\grid\CheckboxColumn'],
                [
                    'attribute' => 'image_id',
                    'format' => 'html',
                    'contentOptions' => ['style' => '', 'width' => '100'],
                    'value' => function($model) {
                return Html::img($model->imgTemp, [ 'width' => '100']);
            }
                ],
                [
                    'attribute' => 'art_code',
                    'format' => 'html',
                    'value' => function($model) {
                        return Html::a($model->art_code, ['view', 'id' => $model->id]);
                    }
                        ],
                        'title',
                        //'status',
                        [
                            'attribute' => 'size',
                            'value' => 'sizeUnitShort'
                        ],
                        // 'art_type_id',
                        // 'art_technique_id',                         
                        [
                            'attribute' => 'artist_id',
                            'format' => 'html',
                            'filter' => Artist::getList(),
                            'value' => function($model) {
                                return $model->artist_id ? $model->artist->displaynameImg : null;
                            }
                        ],
                        [
                            'attribute' => 'status',
                            'format' => 'html',
                            'value' => function($model) {
                                return $model->statusLabel;
                            }
                        ],
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]);
                ?>


            </div><!--box-body pad-->
        </div><!--box box-info-->


        <?php
        $this->registerJs('
  jQuery("#btn-pdf").click(function(){
    var keys = $("#w0").yiiGridView("getSelectedRows");
    console.log(keys);
    if(keys.length>0){
      window.location.href="' . Url::to(['pdf']) . '?id="+keys.join();
    }else{
        alert("กรุณากดเลือกที่จะพิมพ์");
    }
    return false;
  });
');
        