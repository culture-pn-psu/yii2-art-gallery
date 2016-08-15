<?php

use yii\helpers\Html;
use yii\grid\GridView;
use culturePnPsu\artGallery\models\ArtTechnique;
use culturePnPsu\artGallery\models\ArtType;

/* @var $this yii\web\View */
/* @var $searchModel culturePnPsu\artGallery\models\ArtTechniqueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('art', 'เทคนิค');
$this->params['breadcrumbs'][] = ['label' => Yii::t('art', 'ผลงานศิลปะ'), 'url' => ['/art-gallery/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='box box-info'>
    <div class='box-header'>
     <!-- <h3 class='box-title'><?= Html::encode($this->title) ?></h3>-->
    </div><!--box-header -->

    <div class='box-body pad'>

        <p>
            <?= Html::a('<i class="fa fa-plus"></i> '.Yii::t('art', 'เพิ่มเทคนิค'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'title',
                [
                    'attribute' => 'art_type_id',
                    'filter' => ArtType::getList(),
                    'value' => 'artType.title'
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
        ?>


    </div><!--box-body pad-->
</div><!--box box-info-->
