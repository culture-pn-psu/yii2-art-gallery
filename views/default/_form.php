<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\artGallery\models\ArtType;
use backend\modules\artGallery\models\ArtTechnique;
use yii\widgets\MaskedInput;
use backend\modules\artGallery\models\Artist;
use backend\modules\artGallery\models\ArtJob;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\widgets\DepDrop;
/* @var $this yii\web\View */
/* @var $model backend\modules\artGallery\models\ArtJob */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="row">    
    <div class="col-sm-12">

        <div class="row">    
            <div class="col-sm-7">   
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-5">  
                <?= $form->field($model, 'artist_id')->dropDownList(Artist::getList(), ['prompt' => 'เลือก']) ?>
            </div>
        </div>    
        <div class="row">    
            <div class="col-sm-3">    
                <?= $form->field($model, 'art_type_id')->dropDownList(ArtType::getList(), ['prompt' => 'เลือก','id'=>'ddl-art_type',]) ?>
            </div>
            <div class="col-sm-3">    
                <?= $form->field($model, 'art_technique_id')->widget(DepDrop::classname(), [
            'options'=>['id'=>'ddl-art_technique'],
            'data'=> ArtTechnique::getList(),
            'pluginOptions'=>[
                'depends'=>['ddl-art_type'],
                'placeholder'=>'เลือกเทคนิค',
                'url'=>Url::to(['get-technique'])
            ]
        ]); ?>

            </div>
            <div class="col-sm-2">    
                <?= $form->field($model, 'year')->dropDownList(ArtJob::genYear(), ['prompt' => 'เลือก']) ?>


            </div>

            <div class="col-sm-2"> 
                <?=
                $form->field($model, 'size')->widget(MaskedInput::className(), [
                    'mask' => [
                        '9{2,4}x9{2,4}'
                    ],
                ])
                ?>

            </div>
            <div class="col-sm-2">  
                <?= $form->field($model, 'unit')->dropDownList(ArtJob::getItemUnit()) ?>

            </div>
        </div>  

        <?= $form->field($model, 'concept')->textarea(['rows' => 6]) ?>
        <div class="row"> 
            <div class="col-sm-3"> 
                <?= $form->field($model, 'status')->dropDownList(ArtJob::getItemStatus()) ?>
            </div>
            <div class="col-sm-9"> 
                <?= $form->field($model, 'note')->textInput() ?>
            </div>
        </div> 

        <div class="row">
            <div class="col-sm-3">
                <?= $form->field($model, 'image_id')->hiddenInput()->hint(false) ?>

                <div class="thumbnail">
                    <div class="img">             
                        <?= Html::img(Yii::$app->img->getUploadUrl() . Yii::$app->img->no_img, ['class' => 'images-show', 'width' => '100%']) ?>
                    </div>
                    <div class="caption">
                        <div style="height:30px;">
                            <span id="res_img"></span>
                            <p class="pull-right" >
                                <button class="btn btn-select-img btn-left" type="button"><i class="fa fa-angle-left"></i></button>
                                <button class="btn btn-select-img btn-right" type="button"><i class="fa fa-angle-right"></i></button>
                            </p>
                        </div>
                    </div>
                </div> 

            </div>
            <div class="col-sm-9">
                <?=
                $form->field($model, 'images_file[]')->widget(FileInput::classname(), [
                    'options' => [
                        'accept' => 'image/*',
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        'initialPreview' => $model->initialPreview($model->images, 'docs', 'file'),
                        'initialPreviewConfig' => $model->initialPreview($model->images, 'docs', 'config'),
                        'uploadUrl' => Url::to(['uploadajax']),
                        'overwriteInitial' => false,
                        'initialPreviewShowDelete' => true,
                        'showPreview' => true,
                        'showRemove' => true,
                        'showUpload' => true,
                        //'initialPreview'=> $initialPreview,
                        //'initialPreviewConfig'=> $initialPreviewConfig,        
                        'uploadExtraData' => [
                            //'slide_id' => $model->id,
                            'id' => $model->id,
                            'upload_folder' => ArtJob::UPLOAD_FOLDER . "/" . $model->id,
                        //'width' => ArtJob::width,
                        ],
                    //'maxFileSize' => 2000000,
                    //'maxFileCount' => 1,
                    ],
                ])->hint('เป็นไฟล์ JPG,PNG เท่านั้น');
                ?>
            </div>
        </div>



        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('art', 'Create') : Yii::t('art', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    </div>
</div>
<?php ActiveForm::end(); ?>

<?php
$this->registerJs("
    
var imgs=[];
var index=0;
var src;
var src_old = $('#artjob-image_id').val();
var total;
var url_file = '" . Yii::$app->img->getUploadUrl(ArtJob::UPLOAD_FOLDER . "/" . $model->id) . "';
var data = " . ($model->images ? $model->images : '[' . Yii::$app->img->no_img . ']') . ";
var load_img =function(){
    console.log(data);
    imgs=[];
   $.each( data,function(key, value){
        imgs.push(value);
        //console.log(value);
    });
    total=imgs.length;
    $('#res_img').text((index+1)+'/'+total);
    total=total?total-1:0;   

    
}

load_img();
setOld();
function setOld(){
$.each( imgs, function( key, value ) {
        //console.log( key + ':' + value );
        if(src_old==value){
        index=key;
        }
         $('#res_img').text((index+1)+'/'+(total?total+1:0));
    });    
    setVal();
}

$('.btn-select-img').click(function(){
    load_img();
    if($(this).is('.btn-left')){
        //alert('btn-left');
        index=index?index-1:0;
        //src=imgs[index];
    }
    if($(this).is('.btn-right')){
        //alert('btn-right');
         index=(index<total)?index+1:total;
        //src=imgs[index];
    }
    $('#res_img').text((index+1)+'/'+(total?total+1:0));
    //console.log('max:'+max+' index:'+index+' src:'+src+' indexOf:'+src.indexOf('/'));
    //console.log(' index:'+index+' src:'+src+' indexOf:'+src.indexOf('/'));
    setVal();
    
});

function setVal(){
    src=imgs[index];
    $('.images-show').attr('src',url_file+src);
    $('#artjob-image_id').val(src);
}

$('input#artjob-images_file').on('fileuploaded', function(event, data, previewId, index) {
    alert(55);
    var form = data.form, files = data.files, extra = data.extra,
    response = data.response.files, reader = data.reader;
    response = data.response.files  
    //console.log('File batch upload complete ');
    //console.log(response);
    data=data.response.temp;  
    //console.log(data);
    load_img();
});

//$('input#artjob-images_file').on('filedeleted', function(event, key) {
//    console.log('Key = ' + key);
//});
 
");
?>