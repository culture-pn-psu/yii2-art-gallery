<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\artGallery\models\ArtJobSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="art-job-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'size') ?>

    <?= $form->field($model, 'unit') ?>

    <?php // echo $form->field($model, 'art_type_id') ?>

    <?php // echo $form->field($model, 'art_technique_id') ?>

    <?php // echo $form->field($model, 'artist_id') ?>

    <?php // echo $form->field($model, 'concept') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'image_id') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('art', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('art', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
