<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\person\models\Prefix;
use backend\modules\artGallery\models\Artist;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model backend\modules\artGallery\models\Artist */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>

<div class="row">
    <div class="col-sm-3">
 <?= Html::img($model->imgTemp, ['class' => 'img_show thumbnail', 'width' => '100%']) ?> 
        <?php if(!$model->isNewRecord):
            ?>
        
        <?= $form->field($model, 'image_id')->hiddenInput()->label(false); ?> 
        <p>
        <?= Html::button('<i class="glyphicon glyphicon-camera"></i> โหลดรูป', ['value' => Url::to(['/image/upload']), 'title' => Yii::t('app', 'โหลดรูป'), 'class' => 'btn btn-default modal-img photo']);
        ?> 
            </p>
            <?php endif;?>
    </div>
    <div class="col-sm-9">

        <div class="row">
            <div class="col-sm-2">
                <?= $form->field($model, 'prefix_id')->dropDownList(Prefix::getList()) ?>
            </div>
            <div class="col-sm-5">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            </div>
            <div class="col-sm-5">
                <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <?= $form->field($model, 'sex')->dropDownList([ 'f' => 'F', 'm' => 'M',], ['prompt' => '']) ?>

            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?></div>
            <div class="col-sm-5">

                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <?= $form->field($model, 'other')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'status')->textInput() ?>

        <?php /*= $form->field($model, 'created_by')->textInput() ?>

        <?= $form->field($model, 'created_at')->textInput() ?>

        <?= $form->field($model, 'updated_by')->textInput() ?>

        <?= $form->field($model, 'updated_at')->textInput() */?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('art', 'Create') : Yii::t('art', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>



    </div>
</div>
<?php ActiveForm::end(); ?>


<?php
    if (!$model->isNewRecord):
        Modal::begin(['id' => 'modal-img']);
        $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
        ?>
        <?=
        $form->field(new \backend\modules\image\models\Image, 'name_file')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*'],
            'pluginOptions' => [
                'uploadUrl' => Url::to(['/file/default/uploadajax']),
                //'overwriteInitial'=>false,
                'initialPreviewShowDelete' => true,
                //'initialPreview'=> $initialPreview,
                //'initialPreviewConfig'=> $initialPreviewConfig,        
                'uploadExtraData' => [
                    //'slide_id' => $model->id,
                    'upload_folder' => Artist::UPLOAD_FOLDER,
                    'width' => Artist::width,
                ],
                'maxFileCount' => 1,
            ],
            'options' => ['accept' => 'image/*', 'id' => 'name_file']
        ]);
        ?>


        <?php
        ActiveForm::end();
        Modal::end();

        $this->registerJs(' 
    $(".photo").click(function(e) {            
        $("#modal-img").modal("show");        
    });   
    
    $("input[name=\'Image[name_file]\']").on("fileuploaded", function(event, data, previewId, index) {
    //alert(55);
    var form = data.form, files = data.files, extra = data.extra,
        response = data.response.files, reader = data.reader;
    
        response = data.response.files
        console.log("1"+form+"2"+files+"3"+extra+"4"+response+"5"+reader);
        console.log("File batch upload complete"+files);
        loadImg(data.response.path,data.response.files);
        $("#modal-img").modal("hide");
    });

var loadImg = function(path,id){
    $("#artist-image_id").val(id);
    $(".img_show").attr("src",path+id);
}


');

    endif;
    ?>