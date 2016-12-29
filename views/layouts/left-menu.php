<?php

use yii\helpers\Html;
use yii\helpers\BaseStringHelper;

/* @var $this \yii\web\View */
/* @var $content string */

$controller = $this->context;
//$menus = $controller->module->menus;
//$route = $controller->route;
?>
<?php $this->beginContent('@app/views/layouts/main.php') ?>

<div class="row">
    <div class="col-md-3">

        <?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('art', 'เพิ่มงานศิลปะ'), ['/art-gallery/default/create'], ['class' => 'btn btn-primary btn-block margin-bottom']) ?>


        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">                    
                    งานศิลปะ
                </h3>

                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body no-padding">

                <?php
                $nav = new common\models\Navigate();
                echo dmstr\widgets\Menu::widget([
                    'options' => ['class' => 'nav nav-pills nav-stacked'],
                    //'linkTemplate' =>'<a href="{url}">{icon} {label} {badge}</a>',
                    'items' => $nav->menu(8),
                ])
                ?>                 

            </div>
            <!-- /.box-body -->
        </div>

            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        ศิลปิน
                    </h3>

                    <div class="box-tools">
                        <?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('art', 'เพิ่ม'), ['/art-gallery/artist/create'], ['class' => 'btn btn-success  btn-sm']) ?>
                        
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">

                    <?php
                    $nav = new common\models\Navigate();
                    echo dmstr\widgets\Menu::widget([
                        'options' => ['class' => 'nav nav-pills nav-stacked'],
                        //'linkTemplate' =>'<a href="{url}">{icon} {label} {badge}</a>',
                        'items' => $nav->menu(9),
                    ])
                    ?>                 

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        
             <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        จัดการข้อมูลอื่นๆ
                    </h3>

                   
                </div>
                <div class="box-body no-padding">

                    <?php
                    $nav = new common\models\Navigate();
                    echo dmstr\widgets\Menu::widget([
                        'options' => ['class' => 'nav nav-pills nav-stacked'],
                        //'linkTemplate' =>'<a href="{url}">{icon} {label} {badge}</a>',
                        'items' => $nav->menu(11),
                    ])
                    ?>                 

                </div>
                <!-- /.box-body -->
            </div>

    </div>
    <!-- /.col -->


    <div class="col-md-9">
<?= $content ?>
        <!-- /. box -->
    </div>
    <!-- /.col -->


</div>


<?php $this->endContent(); ?>
