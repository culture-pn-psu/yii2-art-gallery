<?php

namespace backend\modules\artGallery\controllers;

use Yii;
use backend\modules\artGallery\models\ArtTechnique;
use backend\modules\artGallery\models\ArtTechniqueSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TechniqueController implements the CRUD actions for ArtTechnique model.
 */
class TechniqueController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all ArtTechnique models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArtTechniqueSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ArtTechnique model.
     * @param integer $art_type_id
     * @param integer $id
     * @return mixed
     */
    public function actionView($art_type_id, $id)
    {
        return $this->render('view', [
            'model' => $this->findModel($art_type_id, $id),
        ]);
    }

    /**
     * Creates a new ArtTechnique model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ArtTechnique();

        if ($model->load(Yii::$app->request->post())){
            if($model->save()) {
            return $this->redirect(['view', 'art_type_id' => $model->art_type_id, 'id' => $model->id]);
            }else{
                print_r($model->getErrors());
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ArtTechnique model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $art_type_id
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($art_type_id, $id)
    {
        $model = $this->findModel($art_type_id, $id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'art_type_id' => $model->art_type_id, 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ArtTechnique model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $art_type_id
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($art_type_id, $id)
    {
        $this->findModel($art_type_id, $id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ArtTechnique model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $art_type_id
     * @param integer $id
     * @return ArtTechnique the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($art_type_id, $id)
    {
        if (($model = ArtTechnique::findOne(['art_type_id' => $art_type_id, 'id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
