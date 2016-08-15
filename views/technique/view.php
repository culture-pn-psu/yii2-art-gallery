<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\artGallery\models\ArtTechnique */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('art', 'Art Techniques'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='box box-info'>
    <div class='box-header'>
     <!-- <h3 class='box-title'><?= Html::encode($this->title) ?></h3>-->
    </div><!--box-header -->
    
    <div class='box-body pad'>

    <p>
        <?= Html::a(Yii::t('art', 'Update'), ['update', 'art_type_id' => $model->art_type_id, 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('art', 'Delete'), ['delete', 'art_type_id' => $model->art_type_id, 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('art', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'art_type_id',
            'id',
            'title',
        ],
    ]) ?>


    </div><!--box-body pad-->
 </div><!--box box-info-->
