<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use culturePnPsu\artGallery\models\ArtType;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\artGallery\models\ArtTechnique */
/* @var $form yii\widgets\ActiveForm */
?>



<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-sm-2">
        <?= $form->field($model, 'id') ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'art_type_id')->dropDownList(ArtType::getList(), ['prompt' => 'เลือก']) ?>


    </div>
</div> 
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('art', 'Create') : Yii::t('art', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>


