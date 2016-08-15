<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel culturePnPsu\artGallery\models\ArtistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('art', 'Artists');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='box box-info'>
    <div class='box-header'>
     <!-- <h3 class='box-title'><?= Html::encode($this->title) ?></h3>-->
    </div><!--box-header -->

    <div class='box-body pad'>
        <p>
            <?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('art', 'เพิ่มศิลปิน'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>


        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => '',
                    'attribute' => 'image_id',
                    'format' => 'html',
                    'contentOptions' => ['style' => '', 'width' => '50'],
                    'value' => function($model) {
                return Html::img($model->imgTemp, [ 'width' => '50']);
            }
                ],
                [
                    'attribute' => 'fullname',
                    'format' => 'html',
                    'value' => function($model) {
                        return Html::a($model->fullname, [ 'view', 'id' => $model->id]);
                    }
                        ],
                        // 'phone',
                        // 'email:email',
                        // 'other:ntext',
                        
                                // 'created_by',
                                // 'created_at',
                                // 'updated_by',
                                // 'updated_at',
                                ['class' => 'yii\grid\ActionColumn'],
                            ],
                        ]);
                        ?>


    </div><!--box-body pad-->
</div><!--box box-info-->
