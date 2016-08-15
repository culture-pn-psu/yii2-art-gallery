<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\artGallery\models\ArtTechnique */

$this->title = Yii::t('art', 'Update {modelClass}: ', [
    'modelClass' => 'Art Technique',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('art', 'Art Techniques'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'art_type_id' => $model->art_type_id, 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('art', 'Update');
?>
<div class='box box-info'>
    <div class='box-header'>
     <!-- <h3 class='box-title'><?= Html::encode($this->title) ?></h3>-->
    </div><!--box-header -->
    
    <div class='box-body pad'>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


    </div><!--box-body pad-->
 </div><!--box box-info-->
