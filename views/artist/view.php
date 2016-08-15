<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\artGallery\models\Artist */

$this->title = $model->fullname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('art', 'Artists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='box box-info'>
    <div class='box-header'>
        <h3 class='box-title'><?= Html::encode($this->title) ?></h3>
        <div class="box-tools">
            <?= Html::a(Yii::t('art', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a(Yii::t('art', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('art', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ])
            ?>
        </div>
    </div><!--box-header -->

    <div class='box-body pad'>



        <div class='row'>
            <div class='col-sm-3'>
                <?= Html::img($model->imgTemp, ['class' => 'thumbnail', 'width' => '100%']) ?> 
            </div>
            <div class='col-sm-9'>

                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        //'id',
                        'fullname',
                        [
                            'attribute' => 'sex',
                            'value' => $model->sexLabel
                        ],
                        'phone',
                        'email:email',
                        'other:ntext',
                        [
                            'attribute' => 'status',
                            'value' => $model->statusLabel
                        ],
                    ],
                ])
                ?>
                <?php
                if ($listDataProvider):
                    echo Html::tag('h3', 'ผลงาน');
                    ?>
                    <div class="row">
                        <div class='list-group gallery'>
                            <?php
                            echo \yii\widgets\ListView::widget([
                                'dataProvider' => $listDataProvider,
                                'layout' => "{pager}<br/>{items}<p>{summary}</p>",
                                'itemView' => function ($model, $key, $index, $widget) {
                                    //echo $model->id;
                                    return $this->render('_list_item', ['model' => $model]);
                                },
                                    ]);
                                    ?>
                                </div>
                            </div>
        <?php endif; ?>



                        <?= $model->getAttributeLabel('created_at') . ' ' . Yii::$app->formatter->asDatetime($model->created_at); ?> 
        <?= $model->getAttributeLabel('created_by') . ' ' . $model->createdBy->displayname; ?> 
                        <br />

                        <?= $model->getAttributeLabel('updated_at') . ' ' . Yii::$app->formatter->asDatetime($model->updated_at); ?> 
        <?= $model->getAttributeLabel('updated_by') . ' ' . $model->updatedBy->displayname; ?> 

            </div>
        </div>

    </div><!--box-body pad-->
</div><!--box box-info-->
