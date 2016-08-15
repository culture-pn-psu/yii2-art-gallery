<?php

namespace backend\modules\artGallery\controllers;

use Yii;
use backend\modules\artGallery\models\Artist;
use backend\modules\artGallery\models\ArtistSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\artGallery\models\ArtJob;
use yii\data\ActiveDataProvider;

/**
 * ArtistController implements the CRUD actions for Artist model.
 */
class ArtistController extends Controller {

    public function behaviors() {
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
     * Lists all Artist models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ArtistSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Artist model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $dataProvider = new ActiveDataProvider([
            'query' => ArtJob::find()->where(['artist_id' => $id])->orderBy('id DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);


        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'listDataProvider' => $dataProvider
        ]);
    }

    /**
     * Creates a new Artist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Artist();

//        print_r(Yii::$app->request->post());
//        exit();
        if ($model->load(Yii::$app->request->post())) {

            $model->created_by = Yii::$app->user->id;
            $model->updated_by = Yii::$app->user->id;
            $model->created_at = time();
            $model->updated_at = time();
            if ($model->save()) {
                return $this->redirect(['update', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Artist model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->updated_by = Yii::$app->user->id;
            $model->updated_at = time();
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Artist model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Artist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Artist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Artist::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
